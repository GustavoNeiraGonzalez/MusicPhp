��#   M u s i c P h p 
 
 
tuve que remover ; de las lineas ;extension=fileinfo y ;extension=zip del archivo php.ini de donde esta instalado php, para poder instalar laravel con composer correctamente
removido ; de ;extension=pdo_mysql para poder realizar las migraciones en laravel

- Error descubierto, put con archivos no funciona en laravel correctamente, por lo que hay que enmascarar la peticion post para que la trate como put, este es un ejemplo usando axios en vueJs: .post('http://127.0.0.1:8000/api/songs/put/2', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
            'X-HTTP-Method-Override': 'PUT'
          }
        })
 donde formdata contiene el archivo (de musica en el caso) y el nombre de cancion 
