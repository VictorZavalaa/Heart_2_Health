import { Calendar, dayjsLocalizer } from 'react-big-calendar';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import dayjs from 'dayjs';
import "dayjs/locale/es";
import utc from 'dayjs/plugin/utc';
import { useEffect, useState } from 'react';
import axiosClient from '../../axiosClient.js';
import { useStateContext } from '../../contexts/ContextProvider.jsx';
import timezone from 'dayjs/plugin/timezone';

dayjs.locale('es');
dayjs.extend(utc);
dayjs.extend(timezone);


function Calendario() {
  
    const localizer = dayjsLocalizer(dayjs);
    const [events, setEvents] = useState([]);
    const [selectedEvent, setSelectedEvent] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const { user } = useStateContext();

    useEffect(() => {
        axiosClient.get('/pacientes/' + user.id + '/citas')
            .then(response => {
                console.log("Citas", response.data);



                const citas = response.data.map(event => {
                    const startTime = dayjs.utc(event.start).tz(dayjs.tz.guess()).add(6, 'hour').toDate();  // Restar 5 horas
                    const endTime = dayjs.utc(event.end).tz(dayjs.tz.guess()).add(6, 'hour').toDate();  // Restar 5 horas
                    return {
                        ...event,
                        start: startTime,
                        end: endTime,
                        title: event.motivo,
                        Doctor: event.Doc,
                        Paciente: event.Pac
                    };
                });

                console.log("Citas", citas);
                setEvents(citas);
            })
            .catch(error => {
                console.error("There was an error!", error);
            });
    }, [user.id]);

    const handleSelectEvent = (event) => {
        setSelectedEvent(event);
        setIsModalOpen(true);
    };

    const handleCloseModal = () => {
        setIsModalOpen(false);
        setSelectedEvent(null);
    }

    return (
        <>
        <h2 style={{textAlign:"center", marginTop: "30px" }}>Calendario de citas</h2>
        <div style={{ height: "100vh", width: "90vw", margin: "auto", marginTop: "50px" }}>

            <Calendar 
                localizer={localizer}
                events={events}
                toolbar={true} 
                messages={{ next: "Siguiente", previous: "Anterior", today: "Hoy", month: "Mes", week: "Semana", day: "Día"}}
                startAccessor="start"
                endAccessor="end"
                onSelectEvent={handleSelectEvent}
            />

            {isModalOpen && selectedEvent && (
                <div style={modalStyle}>
                    <div style={modalContentStyle}>
                        <h2>Resumen de la cita</h2>
                        <p><strong>Fecha de la Cita:</strong> {dayjs(selectedEvent.start).format('YYYY-MM-DD')}</p>
                        <p><strong>Horario:</strong> {dayjs(selectedEvent.start).format('HH:mm')} - {dayjs(selectedEvent.end).format('HH:mm')}</p>
                        <p><strong>Motivo Consulta:</strong> {selectedEvent.title}</p>
                        <p><strong>Doctor:</strong> {selectedEvent.Doctor}</p>
                        <p><strong>Paciente:</strong> {selectedEvent.Paciente}</p>
                        <button onClick={handleCloseModal}>Cerrar</button>
                    </div>
                </div>
            )}
        </div>
        </>
    )
}

// Estilos básicos para el modal
const modalStyle = {
    position: 'fixed',
    top: 0,
    left: 0,
    width: '100%',
    height: '100%',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'center',
    zIndex: 1000,
};

const modalContentStyle = {
    backgroundColor: '#fff',
    padding: '20px',
    borderRadius: '8px',
    textAlign: 'center',
    maxWidth: '500px',
    width: '100%',
};

export default Calendario;
