import React, { useState, useEffect } from 'react';

const Reloj = () => {
  const [hora, setHora] = useState(new Date());

  useEffect(() => {
    const intervalID = setInterval(() => {
      setHora(new Date());
    }, 1000);

    return () => clearInterval(intervalID);
  }, []);

  const formatoHora = {
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
    hour12: false, // Establecer en false para formato de 24 horas
  };

  return (
    <div>
      <h2>{hora.toLocaleTimeString(undefined, formatoHora)}</h2>
    </div>
  );
};

export default Reloj;