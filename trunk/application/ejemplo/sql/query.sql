select usuario_id as Modificar, nombre as Nombre, apellido as Apellido, edad as Edad, prof.profesion as Profesion from usuarios
inner join profesiones prof on (usuarios.prof_id = prof.prof_id)