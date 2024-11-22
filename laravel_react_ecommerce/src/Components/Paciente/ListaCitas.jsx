import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../../axiosClient.js";
import '../../styles/BarraBusqueda.css';
import { useStateContext } from '../../contexts/ContextProvider.jsx';


export default function ListaCitas() {

    const [citas, setCitas] = useState([]);
    const [filteredCitas, setFilteredCitas] = useState([]);
    const [loading, setLoading] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');
    const { user } = useStateContext(); 

        
    // Para obtener las citas
    useEffect(() => {
        getCitas();
    }, []);

    // Para buscar una cita
    useEffect(() => {
        if (searchTerm === '') {
            setFilteredCitas(citas);
        } else {
            setFilteredCitas(
                citas.filter(cita => {
                    const citaDate = new Date(cita.start).toLocaleDateString();
                    return citaDate.includes(searchTerm.toLowerCase());
        })
            
            );
        }
    }, [searchTerm, citas]);



    // Para obtener las citas
    const getCitas = () => {
        setLoading(true);
        axiosClient.get('/pacientes/' + user.id + '/citas')
            .then(({ data }) => {
                setLoading(false);

                console.log("Citas", data);

                if (Array.isArray(data)) {
                    setCitas(data);
                    setFilteredCitas(data);
                } else {
                    console.error("La respuesta de la API no es un array");
                }
            }).catch((error) => {
                console.error("Error al obtener las citas", error);
            });
    };

    return (
        <div>
            <div className="search-container">
                <input
                    type="text"
                    placeholder="Buscar por fecha (yyyy/mm/dd)"
                    value={searchTerm}
                    onChange={e => setSearchTerm(e.target.value)}
                    className="search-bar"
                />
            </div>

            <div className="card animated fadeInDown">
                <div style={{ overflowX: "auto" }}>
                    <h2>Citas</h2><br></br>
                    <table>
                        <thead>    
                            <tr>
                                <th>ID</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                                <th>Doctor</th>
                                <th>Paciente</th>
                                <th>Ver</th>
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
                                {filteredCitas.map(u => (
                                    <tr key={u.id}>
                                        <td>{u.id}</td>
                                        <td>{u.motivo}</td>
                                        <td>{new Date(u.start).toLocaleDateString()}</td>
                                        <td>{u.Doc}</td>
                                        <td>{u.Pac}</td>
                                        <td>                                        
                                            <Link className="btn-edit" to={`/Paciente/Citas/${u.id}/Recomendaciones`}>Recomendaciones</Link>&nbsp;
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        }
                    </table>
                </div>
            </div>
        </div>
    );
}

