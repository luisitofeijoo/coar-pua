import React, {useEffect, useState, useRef} from 'react';
import {useForm} from 'react-hook-form';
import Reloj from './Reloj';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { CircleSpinnerOverlay, FerrisWheelSpinner } from 'react-spinner-overlay'

export default function Asistencia() {

    const {
        register,
        setValue,
        getValues,
        handleSubmit,
        reset,
        formState: {errors},
        watch,
    } = useForm();

    const [search, setSearch] = useState('');
    const [asistencia, setAsistencia] = useState(null);
    const [busquedaEnProceso, setBusquedaEnProceso] = useState(false);
    const [isActiveDelete, setIsActiveDelete] = useState(false);

    const inputBuscarRef = useRef(null);

    const handleChangeSearch = (event) => {
        setSearch(event.target.value);
    };

    const handleBtnBuscar = () => {
        setSearch((prevSearch) => {
            if (prevSearch.trim() !== '') {
                buscarPersona(prevSearch);
            }
            return prevSearch;
        });
    };

    const handleKeyPress = (event) => {
        if (event.key === 'Enter' || event.keyCode === 13) {
            setSearch((prevSearch) => {
                if (prevSearch.trim() !== '') {
                    buscarPersona(prevSearch);
                }
                return prevSearch;
            });
        }
    };

    const handleEliminarRegistro = async () => {
        if(confirm('¡CUIDADO! Esta apunto de eliminar el registro de asistencia del postulante: *'+asistencia.postulante.dni+' | '+asistencia.postulante.nombres+' '+asistencia.postulante.apellidos+', ¿Desea continuar?')) {
            setIsActiveDelete(true);
            try {
                const response = await axios.post('/api/asistencia/eliminar/'+asistencia.asistencia.id);
                const data = response.data;
                setAsistencia(null);
                inputBuscarRef.current.focus();
                toast.success('Registro del postulante eliminado correctamente.', {
                    position: "top-right",
                    autoClose: 5000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                    theme: "colored",
                });
            } catch (error) {
                toast.error('Ocurrio un error, nose pudo eliminar el registro de asistencia del postulante.', {
                    position: "top-right",
                    autoClose: 5000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                    theme: "colored",
                });
            } finally  {
                setIsActiveDelete(false);
            }
        }
    }

    const buscarPersona = async (dni) => {

        // Verificar si la búsqueda ya está en proceso
        if (busquedaEnProceso) {
            return;
        }

        // Actualizar el estado para indicar que la búsqueda está en proceso
        setAsistencia(null);
        setBusquedaEnProceso(true);

        inputBuscarRef.current.focus();
        inputBuscarRef.current.value = "";
        setSearch("");

        try{
            // Realiza la solicitud GET al servidor utilizando Axios
            const response = await axios.get('/api/asistencia/guardar/'+dni);
            const data = response.data;
            //Actualiza el estado con los datos obtenidos
            setAsistencia(data);
        } catch (error) {
            setAsistencia(null);
            toast.error('Postulante no encontrado...', {
                position: "top-right",
                autoClose: 5000,
                hideProgressBar: false,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
                progress: undefined,
                theme: "colored",
            });
        } finally {
            // Restablecer el estado después de que la función haya terminado
            setBusquedaEnProceso(false);
        }
    };

    const estadoClases = {
        nuevo: 'is-success',
        registrado: 'is-danger',
        no_encontrado: 'is-danger',
        turno_incorrecto: 'is-warning'
    }

    useEffect( () => {
        inputBuscarRef.current.focus();
    }, []);

    return (
        <>
            {isActiveDelete && (<>
                <CircleSpinnerOverlay
                loading={isActiveDelete}
                overlayColor="rgba(255,255,255,0.8)"
                message={"Procesando, espere un momento porfavor..."}
                /></>
            )}
            <ToastContainer />
            <div className="container">
                <div className="field has-addons">
                    <div className="control is-expanded">
                        <input
                            type="number"
                            onChange={handleChangeSearch}
                            onKeyDown={handleKeyPress}
                            ref={inputBuscarRef}
                            className="input"
                            placeholder="Ingrese DNI | Pasar lectora de código de barras"
                        />
                    </div>
                    <div className="control">
                        <a className="button is-info" onClick={handleBtnBuscar}>
                            Buscar
                        </a>
                    </div>
                </div>

                {/* <Reloj/>*/}
                {busquedaEnProceso && (
                    <div className="has-text-centered">
                        <div className="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                    </div>
                )}

                {asistencia && (<>
                    <article className={"panel "+estadoClases[asistencia.estado]}>
                        <p className="panel-heading has-text-centered">
                            {asistencia.mensaje}
                        </p>
                        <div className="card">
                            <div className="card-content">
                                <div className="content pb-5">
                                    <div className="columns is-vcentered">
                                        <div className="column">
                                            <div className="is-size-5">
                                                <strong>DNI:</strong> {asistencia.postulante.dni} <br/>
                                                <span className={"is-size-2 is-uppercase is-block mt-3 mb-3"} >{asistencia.postulante.nombres} <br/> {asistencia.postulante.apellidos}</span>
                                                <strong>Local de aplicación:</strong> <br/>
                                                <span className="is-size-4"> {asistencia.programacion.sede}</span> <br/>
                                                <small>{ asistencia.postulante.ubigeo_detalle }</small>
                                                <div className="columns">
                                                 {/*   <div className="column">
                                                        <strong>Turno:</strong> <br/>
                                                        <span className="is-size-4"> {asistencia.programacion.turno}</span> <br/>
                                                    </div>
                                                    <div className="column">
                                                        <strong>Hora:</strong> <br/>
                                                        <span className="is-size-4"> {asistencia.programacion.fecha}</span> <br/>
                                                    </div>*/}
                                                </div>
                                            </div>
                                        </div>
                                        <div className="column has-text-right has-text-centered-mobile is-one-third">
                                            <div className="has-text-right" style={{ lineHeight: '20px' }}>
                                                <small className="is-size-7 has-text-weight-bold">FECHA DE REGISTRO:</small> <br/>
                                                <span className="is-size-5 has-text-weight-medium has-text-danger-dark"> {asistencia.asistencia?.fecha_asistencia?? 'No registrado'}</span> <br/>
                                            </div>
                                            <div className="mt-5 box is-align-items-center is-full is-fullwidth">
                                                <p className="has-text-centered m-0 p-0 is-size-6">PABELLÓN</p>
                                                <p className="has-text-centered is-size-2-desktop is-size-3-tablet">{asistencia.postulante.pabellon}</p>
                                            </div>
                                            <div className="columns">
                                                <div className="column is-6">
                                                    <div className="box">
                                                        <p className="has-text-centered m-0 p-0 is-size-6">PISO</p>
                                                        <p className="has-text-centered is-size-2">{asistencia.postulante.piso}</p>
                                                    </div>
                                                </div>
                                                <div className="column is-6">
                                                    <div className="box">
                                                        <p className="has-text-centered m-0 p-0 is-size-6">AULA</p>
                                                        <p className="has-text-centered is-size-2">{asistencia.postulante.aula}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <div className='has-text-centered'>
                        {estadoClases[asistencia.estado] === 'is-success' && (<>
                            <article class="message is-warning">
  <div class="message-body">
  <i><strong>Nota:</strong> Solo utilizar el botón <em>eliminar</em> si tuvo una equivocación en el registro.</i>
    <a className='has-text-centered' onClick={handleEliminarRegistro}> <strong className='pl-2 has-text-link'>Eliminar</strong></a>
  </div>
</article>



                        </>)}
                    </div>
                    </>
                )}
            </div>
        </>
    );
}
