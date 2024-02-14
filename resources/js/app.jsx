import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';

import Asistencia from './Asistencia';
import AsistenciaResumen from "./AsistenciaResumen";

const app1 = document.getElementById('app');
const app2 = document.getElementById('app_general');

if(app1) {
    ReactDOM.createRoot(app1).render(<Asistencia/>);
}


if(app2) {
    ReactDOM.createRoot(app2).render(<AsistenciaResumen/>);
}


