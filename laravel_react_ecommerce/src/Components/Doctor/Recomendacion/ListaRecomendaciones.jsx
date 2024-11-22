import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../../../axiosClient.js';
import '../../../styles/BarraBusqueda.css';
import Swal from 'sweetalert2';

export default function ListaRecomendaciones() {
    const { id } = useParams(); // Extrae el id de la cita desde la URL
    const [recomendaciones, setRecomendaciones] = useState([]);
    const [filteredRecomendaciones, setFilteredRecomendaciones] = useState([]);
    const [loading, setLoading] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');

    

    // Para obtener las recomendaciones de la cita específica
    useEffect(() => {
        if (id) {
            getRecomendaciones();
        }
    }, [id]);

    // Función para eliminar una recomendacion
    const onDeleteClick = recomendacion => {

        Swal.fire({
            title: "¿Estás seguro?",
            text: "Una vez eliminado, ¡No podrá recuperar este registro!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, bórralo!",
        }).then((result) => {

            if (result.isConfirmed) {
                axiosClient.delete(`/recomendaciones/${recomendacion.id}`)
                .then(() => {

                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "El registro ha sido eliminado.",
                        icon: "success",
                    });
                    setTimeout(() => {
                        getRecomendaciones();
                    }, 1000);
                })
            }
        });                  
    }

    // Para buscar una recomendacion
    useEffect(() => {
        if (searchTerm === '') {
            setFilteredRecomendaciones(recomendaciones);
        } else {
            setFilteredRecomendaciones(
                recomendaciones.filter(recomendacion => {
                    const recomendacionDate = new Date(recomendacion.FechRec).toLocaleDateString('es-ES', { timeZone: 'UTC' });
                    return recomendacionDate.includes(searchTerm.toLowerCase());
        })
            
            );
        }
    }, [searchTerm,recomendaciones]);



    // Para obtener las recomendaciones
    const getRecomendaciones = () => {
        setLoading(true);
        axiosClient.get('/doctor/citas/'+id+'/recomendaciones')
        .then(({ data }) => {
                console.log(data);
                setLoading(false);
                if (Array.isArray(data)) {
                    setRecomendaciones(data);
                    setFilteredRecomendaciones(data);
                } else {
                    console.error("La respuesta de la API no es un array");
                }
            })
            .catch((error) => {
                setLoading(false);
                console.error("Error al obtener los seguimientos", error);
            });
    };

    return (
        <div>
            <div className="search-container">
                <input
                    type="text"
                    placeholder="Buscar por fecha (yyyy/mm/dd)"
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="search-bar"
                />
            </div>

            <div style={{ display: 'flex', justifyContent: "space-between", alignItems: "center" }}>
                <Link className="btn-add" to={`/Doctor/Citas/${id}/Recomendaciones/new`}>Nueva Recomendación</Link>
            </div>

            <div className="card animated fadeInDown">
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Fecha</th>
                            <th>Recomendación asignada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    {loading &&
                        <tbody>
                            <tr>
                                <td colSpan="5" className="text-center">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    }
                    {!loading &&
                        <tbody>
                            {filteredRecomendaciones.map(u => (
                                <tr key={u.id}>
                                    <td>{u.id}</td>
                                    <td>{new Date(u.FechRec).toLocaleDateString('es-ES', { timeZone: 'UTC' })}</td>
                                    <td>{u.DesRec}</td>
                                    <td>
                                        <Link className="btn-edit" to={`/Doctor/Citas/${u.idCita}/Recomendaciones/${u.id}`}>Editar</Link>
                                        &nbsp;
                                        <button className="btn-delete" onClick={ev => onDeleteClick(u)}>Eliminar</button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    }
                </table>
            </div>
        </div>
    );
}