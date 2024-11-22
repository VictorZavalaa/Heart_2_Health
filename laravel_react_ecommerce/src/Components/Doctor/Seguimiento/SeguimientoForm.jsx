import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import axiosClient from '../../../axiosClient';
import '../../../styles/Formularios.css';
import NavbarDoctor from '../NavbarDoctor.jsx';

export default function SeguimientoForm() {

    const { id, idC } = useParams(); // Extrae el id del seguimiento y la cita desde la URL
    const navigate = useNavigate(); // Hook para navegar entre páginas
    const [loading, setLoading] = useState(false); // Estado para saber si se está cargando la información
    const [errors, setErrors] = useState(null); // Estado para guardar los errores
    const [idPac, setIdPac] = useState(null); // Estado para guardar el id del paciente
    const [nombrePaciente, setNombrePaciente] = useState(''); // Estado para guardar el nombre del paciente
    const [sintomas, setSintomas] = useState([]); // E  stado para guardar la lista de síntomas
    const [cita, setCita] = useState({ EstadoCita: 'Desatendida' }); // Estado para los datos de la cita


    console.log("idCita", idC);
    console.log("idSeguimiento", id);

    const [seguimientos, setSeguimientos] = useState({ // Estado para guardar los datos del formulario
        id: null,
        FechSeg: '',
        DetalleSeg: '',
        Glucosa: '',
        Ritmo_Cardiaco: '',
        Presion: '',
        idCita: idC, // Usamos idCita del parámetro de la URL
    });

    const [diagnosticos, setDiagnosticos] = useState({ // Estado para guardar los datos del formulario
        id: null,
        idPaciente: '',
        idSintoma: '',
    });

    //Obtener la lista de síntomas para el formulario
    useEffect(() => {
        axiosClient.get('/sintomas')
            .then(({ data }) => {
                console.log("Sintomas data:", data);
                setSintomas(data.data || []);
            })
            .catch((error) => {
                console.error("Error al obtener los sintomas", error);
            });
    }, []);


    // Este useEffect carga el seguimiento si existe un id en los parámetros
    useEffect(() => {
        if (id) { // Verifica que haya un id para editar
            setLoading(true);
            axiosClient.get(`/doctor/citas/${idC}/seguimientos/${id}`)
                .then(({ data }) => {
                    setLoading(false);
                    setSeguimientos(data); // Carga los datos del seguimiento
                })
                .catch((error) => {
                    setLoading(false);
                    console.error("Error al obtener los seguimientos", error);
                });
        }
    }, [id, idC]); // Dependencias: ejecuta este efecto si id o idC cambian

    // Obtener id y nombre del paciente (creo no sirve aquí pero abajo en el onSubmit sí)
    useEffect(() => {
        if (idC) { 
            axiosClient.get(`/doctor/citas/${idC}`)
                .then((response) => {
                    console.log("Datos del paciente:", response.data);
                    const pacienteData = response.data[0]; // Asegúrate de acceder al primer elemento del array
                    setIdPac(pacienteData.idPac);
                    setNombrePaciente(pacienteData.NomPac);
                })
                .catch(error => {
                    console.error("Error al obtener los detalles de la cita", error);
                });
        }
    }, [idC]);

    // Obtener los detalles de la cita
    useEffect(() => {
        if (idC) { 
            axiosClient.get(`/doctor/citas/${idC}`)
                .then((response) => {
                    setCita(response.data[0]); // Asignamos la cita obtenida al estado
                })
                .catch(error => {
                    console.error("Error al obtener los detalles de la cita", error);
                });
        }
    }, [idC]);

    const onSubmit = ev => {
        ev.preventDefault();

        const currentDate = new Date().toISOString().split('T')[0];
        const payloadSeguimiento = { ...seguimientos, idCita: idC, FechSeg: currentDate };
    
        if (id) {
            // Actualización de seguimiento
            axiosClient.put(`/doctor/citas/${idC}/seguimientos/${id}`, payloadSeguimiento)
                .then(() => {
                    // Actualiza el estado del seguimiento
                    const payloadCita = { EstadoCita: 'Atendida' }; // Solo actualiza el estado
                    axiosClient.put(`/citas/${idC}`, payloadCita)
                        .then(() => {


                            //Actualiza el diagnostico
                            axiosClient.get(`/doctor/citas/${idC}`)
                                .then((response) => {
                                    console.log("Datos del paciente:", response.data);
                                    const pacienteData = response.data[0]; // Asegúrate de acceder al primer elemento del array
                                    const payloadDiagnostico = { ...diagnosticos, idPaciente: pacienteData.idPaciente};
                                    console.log ("Payload Diagnostico", payloadDiagnostico);
                                    axiosClient.put(`/diagnostico_sintoma`, payloadDiagnostico)
                                        .then(() => {
                                            console.log("Diagnóstico creado correctamente.");
                                        })
                                })
                                .catch(error => {
                                    console.error("Error al obtener los detalles de la cita", error);
                                })
                            console.log("Estado de la cita actualizado a 'Atendida'.");
                            navigate(`/doctor/citas/${idC}/seguimientos`);


                        })
                        .catch(err => {
                            console.error("Error al actualizar el estado de la cita", err.response?.data);
                        });
                })
                .catch(err => {
                    const response = err.response;
                    console.error("Error al actualizar el seguimiento", response?.data);
    
                    if (response && response.status === 422) {
                        setErrors(response.data.errors);
                    }
                });
        } else {
            // Creación de seguimiento
            axiosClient.post('/seguimientos', payloadSeguimiento)
                .then(() => {
                    // Luego de crear el seguimiento, actualiza el estado de la cita
                    const payloadCita = { EstadoCita: 'Atendida' }; // Solo actualiza el estado
                    axiosClient.put(`/citas/${idC}`, payloadCita)
                        .then(() => {


                            //Creación de diagnositco
                            axiosClient.get(`/doctor/citas/${idC}`)
                                .then((response) => {
                                    console.log("Datos del paciente:", response.data);
                                    const pacienteData = response.data[0]; // Asegúrate de acceder al primer elemento del array
                                    const payloadDiagnostico = { ...diagnosticos, idPaciente: pacienteData.idPaciente};
                                    console.log ("Payload Diagnostico", payloadDiagnostico);
                                    axiosClient.post(`/diagnostico_sintoma`, payloadDiagnostico)
                                        .then(() => {
                                            console.log("Diagnóstico creado correctamente.");
                                        })
                                })
                                .catch(error => {
                                    console.error("Error al obtener los detalles de la cita", error);
                                })
                            console.log("Estado de la cita actualizado a 'Atendida'.");
                            navigate(`/doctor/citas/${idC}/seguimientos`);


                        })
                        .catch(err => {
                            console.error("Error al actualizar el estado de la cita", err.response?.data);
                        });
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
        <NavbarDoctor />

        <div className="background-container2">
            <div className="form-container2">
                {id && <h1 style={{ textAlign: 'center' }}>Editar Seguimiento: {seguimientos.DetalleSeg}</h1>}
                {!id && <h1>Nuevo Seguimiento</h1>}

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
                            <label>Detalle del Seguimiento</label>
                                <input value={seguimientos.DetalleSeg} onChange={ev => setSeguimientos({...seguimientos, DetalleSeg: ev.target.value})} placeholder='Detalle del seguimiento'/>
                            <label>Nivel de Glucosa del Paciente</label>
                                <input value={seguimientos.Glucosa} onChange={ev => setSeguimientos({...seguimientos, Glucosa: ev.target.value})} placeholder="Glucosa" />
                            <label>Ritmo Cardiaco del Paciente</label>
                                <input value={seguimientos.Ritmo_Cardiaco} onChange={ev => setSeguimientos({...seguimientos, Ritmo_Cardiaco: ev.target.value})} placeholder="Ritmo Cardíaco" />
                            <label>Presión del Paciente</label>
                                <input value={seguimientos.Presion} onChange={ev => setSeguimientos({...seguimientos, Presion: ev.target.value})} placeholder="Presión" />
                            
                            
                            <h1 style={{textAlign: 'left'}}>Sintoma que presenta el paciente {nombrePaciente}: </h1>

                            <select value={diagnosticos.idSintoma} onChange={ev => setDiagnosticos({ ...diagnosticos, idSintoma: ev.target.value })}>
                                <option value="">Selecciona un síntoma</option>
                                {sintomas.map(sintoma => (
                                    <option key={sintoma.id} value={sintoma.id}>
                                        {sintoma.NomSintoma}
                                    </option>
                                ))}
                            </select>

                            <button className="btn" >Guardar</button>
                        </form>
                    )}
                </div>
            </div>
        </div>
    </div>
    );
}
