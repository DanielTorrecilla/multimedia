// script.js

document.addEventListener('DOMContentLoaded', function() {
    // Aquí puedes agregar tus funciones de reproducción de canciones o películas.
    // Por ejemplo, para reproducir una canción podrías usar la API de audio de HTML5:
    
    var audioPlayer = document.createElement('audio');
    
    function playSong(url) {
        if(audioPlayer) {
            audioPlayer.pause();
            audioPlayer = new Audio(url);
            audioPlayer.play();
        }
    }
    
    // Suponiendo que tienes un enlace o botón para cada canción con una clase '.play-song'
    var playButtons = document.querySelectorAll('.play-song');
    
    playButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var songUrl = this.getAttribute('href'); // Asume que el enlace contiene la URL de la canción.
            playSong(songUrl);
        });
    });
});
