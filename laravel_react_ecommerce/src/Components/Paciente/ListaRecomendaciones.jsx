import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axiosClient.js";
import '../../styles/BarraBusqueda.css';
import NavbarPaciente from "./NavbarPaciente.jsx";

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
        axiosClient.get('/paciente/citas/'+id+'/recomendaciones')
        .then(({ data }) => {
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

            <NavbarPaciente />


            <div className="search-container">
                <input
                    type="text"
                    placeholder="Buscar por fecha (yyyy/mm/dd)"
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="search-bar"
                />
            </div>

            <div className="card animated fadeInDown">
                <h2>Recomendaciones</h2><br></br>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Recomendación asignada</th>
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
                                    <td>{new Date(u.FechRec).toLocaleDateString('es-ES', { timeZone: 'UTC' })}</td>
                                    <td>{u.DesRec}</td>
                                </tr>
                            ))}
                        </tbody>
                    }
                </table>
            </div>
        </div>
    );
}