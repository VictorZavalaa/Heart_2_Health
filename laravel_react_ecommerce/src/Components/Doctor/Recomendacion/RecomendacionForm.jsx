import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import axiosClient from '../../../axiosClient';
import '../../../styles/Formularios.css';
import NavbarDoctor from '../NavbarDoctor.jsx';

export default function RecomendacionForm() {

    const { id, idC } = useParams(); // Extrae el id de la recomendacion y la cita desde la URL
    const navigate = useNavigate(); // Hook para navegar entre páginas
    const [loading, setLoading] = useState(false); // Estado para saber si se está cargando la información
    const [errors, setErrors] = useState(null); // Estado para guardar los errores

    console.log("idCita", idC);
    console.log("idRecomendación", id);

    const [recomendaciones, setRecomendaciones] = useState({ // Estado para guardar los datos del formulario
        'id': null,
        'DesRec': '',
        'FechRec': '',
        'idCita': idC, // Usamos idCita del parámetro de la URL
    });


    // Este useEffect carga la recomendación si existe un id en los parámetros
    useEffect(() => {
        if (id) { // Verifica que haya un id para editar
            setLoading(true);
            axiosClient.get(`/doctor/citas/${idC}/recomendaciones/${id}`)
                .then(({ data }) => {
                    setLoading(false);
                    setRecomendaciones(data); // Carga los datos de la recomendación
                })
                .catch((error) => {
                    setLoading(false);
                    console.error("Error al obtener las recomendaciones", error);
                });
        }
    }, [id, idC]); // Dependencias: ejecuta este efecto si id o idC cambian


    const onSubmit = ev => {
        ev.preventDefault();
        const currentDate = new Date().toISOString().split('T')[0];
        const payload = { ...recomendaciones, idCita: idC, FechRec: currentDate };
        console.log("Datos:", payload);
    
        if (id) {
            // Actualización de recomendación
            axiosClient.put(`/doctor/citas/${idC}/recomendaciones/${id}`, payload)
                .then(() => {
                    navigate(`/doctor/citas/${idC}/recomendaciones`);
                });
        } else {
            // Creación de recomendación
            axiosClient.post('/recomendaciones', payload)
                .then(() => {
                    navigate(`/doctor/citas/${idC}/recomendaciones`);
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
                {id && <h1 style={{ textAlign: 'center' }}>Editar Recomendacion: {recomendaciones.DesRec}</h1>}
                {!id && <h1>Nueva Recomendacion de la Cita</h1>}

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
                            <label>Ingrese la recomendación que le da al Paciente</label>
                                <input value={recomendaciones.DesRec} onChange={ev => setRecomendaciones({...recomendaciones, DesRec: ev.target.value})} placeholder='Desc. de la recomendación'/>
                            <button className="btn" >Guardar</button>
                        </form>
                    )}
                </div>
            </div>
        </div>
        </div>
    );
}
