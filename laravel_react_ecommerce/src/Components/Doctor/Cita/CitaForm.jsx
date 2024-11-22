import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import axiosClient from '../../../axiosClient';
import '../../../styles/Formularios.css';
import NavbarDoctor from '../NavbarDoctor.jsx';
import moment from 'moment';


export default function CitaForm() {
    const { id } = useParams(); // Obtener el id de la cita (si es una edición)
    const navigate = useNavigate(); // Hook para navegar entre páginas

    const [citas, setCitas] = useState({
        id: null,
        FechaYHoraInicioCita: '',
        FechaYHoraFinCita: '',
        MotivoCita: '',
        EstadoCita: 'Desatendida', // Por defecto, el estado de la cita es "Desatendida"
        idPaciente: '',
        idDoctor: '', // Este campo ya no será seleccionado por el usuario, se asignará automáticamente
    });

    const [pacientes, setPacientes] = useState([]); // Estado para guardar la lista de pacientes
    const [loading, setLoading] = useState(false); // Estado para saber si se está cargando la información
    const [errors, setErrors] = useState(null); // Estado para guardar los errores
    const [doctorId, setDoctorId] = useState(null); // El id del doctor logueado

    // Obtener la lista de pacientes al cargar el formulario
    useEffect(() => {
        axiosClient.get('/pacientes')
            .then(({ data }) => {
                console.log("Pacientes data:", data);
                setPacientes(data.data || []);
            })
            .catch((error) => {
                console.error("Error al obtener los pacientes", error);
            });
    }, []);

    // Obtener el id del doctor automáticamente
    useEffect(() => {
        axiosClient.get('/auth/user') // Ruta que devuelve el usuario autenticado
            .then(({ data }) => {
                console.log('Doctor ID:', data.id); // Verifica que se obtiene el id correctamente
                setDoctorId(data.id); // Asignamos el id del doctor logueado
            })
            .catch((error) => {
                console.error('Error al obtener el usuario autenticado', error);
            });
    }, []);

    
    // Si existe el id de la cita (edición)
    if (id) {
        useEffect(() => {
            setLoading(true);
            axiosClient.get(`/citas/${id}`)
                .then(({ data }) => {

                // Función de formato para convertir a 'yyyy-MM-ddTHH:mm'
                const formatDate = (dateString) => {
                    const date = new Date(dateString); // Convierte la fecha en un objeto Date

                    // Ajuste para asegurar que mantiene la hora UTC de la base de datos
                    const year = date.getUTCFullYear();
                    const month = String(date.getUTCMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
                    const day = String(date.getUTCDate()).padStart(2, '0');
                    const hours = String(date.getUTCHours()).padStart(2, '0');
                    const minutes = String(date.getUTCMinutes()).padStart(2, '0');

                    return `${year}-${month}-${day}T${hours}:${minutes}`; // Retorna el formato adecuado
                };

                // Formatear las fechas para el input
                const formattedFechaInicio = formatDate(data.FechaYHoraInicioCita);
                const formattedFechaFin = formatDate(data.FechaYHoraFinCita);

                    setLoading(false);
                    setCitas({
                        ...data,
                        FechaYHoraInicioCita: formattedFechaInicio,
                        FechaYHoraFinCita: formattedFechaFin

                    }); // Cargar los datos de la cita para edición
                })
                .catch((error) => {
                    setLoading(false);
                    console.error("Error al obtener las citas", error);
                });
        }, []);
    }

    // Función para enviar los datos del formulario
    const onSubmit = ev => {
        ev.preventDefault();

        const fechaInicio = new Date(citas.FechaYHoraInicioCita);
        const fechaFin = new Date(citas.FechaYHoraFinCita);
        
        // Convertir a formato Y-m-d H:i:s
        const fechaInicioFormatted = fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1).toString().padStart(2, '0') + '-' + fechaInicio.getDate().toString().padStart(2, '0') + ' ' + fechaInicio.getHours().toString().padStart(2, '0') + ':' + fechaInicio.getMinutes().toString().padStart(2, '0') + ':' + fechaInicio.getSeconds().toString().padStart(2, '0');
        const fechaFinFormatted = fechaFin.getFullYear() + '-' + (fechaFin.getMonth() + 1).toString().padStart(2, '0') + '-' + fechaFin.getDate().toString().padStart(2, '0') + ' ' + fechaFin.getHours().toString().padStart(2, '0') + ':' + fechaFin.getMinutes().toString().padStart(2, '0') + ':' + fechaFin.getSeconds().toString().padStart(2, '0');
        

        // Asegurarnos de que el idDoctor esté incluido y sea un número entero
        const payload = { ...citas, idDoctor: doctorId, FechaYHoraInicioCita: fechaInicioFormatted, FechaYHoraFinCita: fechaFinFormatted };

        console.log('Datos a enviar:', payload); // Verifica que el idDoctor esté incluido

        if (citas.id) {
            // Si la cita tiene un id (se está editando)
            axiosClient.put(`/citas/${citas.id}`, payload)
                .then(() => {
                    navigate('/Doctor/citas');
                })
                .catch(err => {
                    const response = err.response;
                    console.error("Error al actualizar la cita", response.data);
                    if (response && response.status === 422) {
                        setErrors(response.data.errors);
                    }
                });
        } else {
            // Si la cita no tiene un id (es nueva)
            axiosClient.post('/citas', payload)
                .then(() => {
                    navigate('/Doctor/citas');
                })
                .catch(err => {
                    const response = err.response;
                    console.error(response.data);
                    if (response && response.status === 422) {
                        setErrors(response.data.errors);
                    }
                });
        }
    };

    return (
        <div>
            <NavbarDoctor></NavbarDoctor>
        <div className="background-container2">
            <div className="form-container2">
                {citas.id && <h1 style={{ textAlign: 'center' }}>Editar Cita</h1>}
                {!citas.id && <h1>Nueva cita</h1>}

                <div className="card animated fadeInDown">
                    {loading && (
                        <div className="text-center">
                            Loading...
                        </div>
                    )}
                    {errors &&
                        <div className="alert">
                            {Object.keys(errors).map(key => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    }
                    {!loading && (
                        <form onSubmit={onSubmit}>
                            <label>Inicio de la Cita</label>
                            <input
                                type="datetime-local"
                                value={citas.FechaYHoraInicioCita}
                                onChange={ev => setCitas({ ...citas, FechaYHoraInicioCita: ev.target.value })}
                            />
                                <label>Fin de la Cita</label>
                                <input
                                    type="datetime-local"
                                    value={citas.FechaYHoraFinCita}
                                    onChange={ev => setCitas({ ...citas, FechaYHoraFinCita: ev.target.value })}
                                />
                                <label>Motivo de la Cita:</label>
                                <input value={citas.MotivoCita} onChange={ev => setCitas({ ...citas, MotivoCita: ev.target.value })} placeholder="Motivo de la cita" />
                            <label>Estado de la cita:</label>
                                <input value={citas.EstadoCita} readOnly placeholder="Estado de la cita (desatendida)" />

                            <label>Paciente:</label>
                            <select value={citas.idPaciente} onChange={ev => setCitas({ ...citas, idPaciente: ev.target.value })}>
                                <option value="">Selecciona un paciente</option>
                                {pacientes.map(paciente => (
                                    <option key={paciente.id} value={paciente.id}>
                                        {paciente.NomPac} {paciente.ApePatPac} {paciente.ApeMatPac}
                                    </option>
                                ))}
                            </select>

                            <br />
                            <button className="btn">Guardar</button>
                        </form>
                    )}
                </div>
            </div>
        </div>
        </div>
    );
}
