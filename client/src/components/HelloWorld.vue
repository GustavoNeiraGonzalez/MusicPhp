<template>
  <div>
    <h1>Subir Canción</h1>
    <form @submit.prevent="submitForm">
      <div>
        <label for="songName">Nombre de la canción:</label>
        <input type="text" id="songName" v-model="songName" name="song_name" />
      </div>
      <br>
      <div>
        <label for="songFile">Archivo de la canción:</label>
        <input type="file" id="songFile" ref="songFile" />
      </div>
      <button type="submit">Subir Canción</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      songName: '',
    };
  },
  methods: {
    submitForm() {
      const songFile = this.$refs.songFile.files[0];
      const formData = new FormData();
      formData.append('song_name', this.songName);
      formData.append('song', songFile);

      axios
        .put('http://127.0.0.1:8000/api/songs/put/2', formData)
        .then(response => {
          console.log('Canción subida con éxito', response.data);
          // Aquí puedes realizar acciones adicionales después de subir la canción
        })
        .catch(error => {
          console.error('Error al subir la canción', error);
          // Aquí puedes manejar el error de acuerdo a tus necesidades
        });
    },
  },
};
</script>

<style>
/* Estilos adicionales */
</style>
