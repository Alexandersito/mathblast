// Función para desplazar el contenedor del chat hacia abajo
function scrollToBottom() {
    var chatContainer = document.getElementById('chatContainer');
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

// Función para verificar si el usuario está cerca de la parte inferior del contenedor
function isUserAtBottom() {
    var chatContainer = document.getElementById('chatContainer');
    return chatContainer.scrollHeight - chatContainer.scrollTop <= chatContainer.clientHeight + 100;
}

// Desplazar hacia abajo al cargar la página
window.onload = scrollToBottom;

const conn = new WebSocket('ws://localhost:8080');

conn.onopen = function (e) {
    console.log("Connection established!");
};

conn.onmessage = function (e) {
    console.log("Mensaje recibido:", e.data); // Verifica el mensaje aquí
    const msgData = JSON.parse(e.data);
    const chatContainer = document.getElementById('chatContainer');
    const messageElement = document.createElement('li');
    messageElement.classList.add('message');

    const timeElement = document.createElement('span');
    timeElement.classList.add('time');
    timeElement.textContent = msgData.fecha;

    const avatarElement = document.createElement('img');
    avatarElement.classList.add('user-avatar');
    avatarElement.src = urlServidor + msgData.img;
    avatarElement.alt = 'Avatar';

    var urlAmigable = convertirAUrlAmigable(msgData.nombre + msgData.id)
    console.log(urlAmigable)
    const anchorElement = document.createElement('a');
    anchorElement.href = `${urlPrincipal}${urlAmigable}`; // Asigna la URL dinámica
    anchorElement.appendChild(avatarElement);

    const nameElement = document.createElement('span');
    nameElement.classList.add('name');
    const truncatedName = msgData.nombre.length > 18 ? msgData.nombre.substring(0, 18) : msgData.nombre;
    nameElement.textContent = truncatedName + ':';

    const textElement = document.createElement('span');
    textElement.classList.add('text');
    textElement.textContent = msgData.contenido;

    messageElement.appendChild(timeElement);
    messageElement.appendChild(anchorElement);
    messageElement.appendChild(nameElement);
    messageElement.appendChild(textElement);

    chatContainer.appendChild(messageElement);

    if (isUserAtBottom()) {
        scrollToBottom();
    }

};

$(".send-button").click(function (e) {
    e.preventDefault();

    const chatInput = document.querySelector('.chat-input').value;
    const idAlumno = document.getElementById('idAlumno').value;

    if (idAlumno == "none") {

        swal({
            type: "error",
            title: "¡ERROR!",
            text: "¡Debes iniciar sesión para poder escribir!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"

        }).then(function (result) {

            document.getElementById('overlayLogin').style.display = 'flex';

            document.getElementById('overlayLogin').addEventListener('click', function (event) {
                if (event.target === this) {
                    document.getElementById('overlayLogin').style.display = 'none';
                }
            });
        });

    } else {

        if (chatInput == "") {

            swal({
                type: "error",
                title: "¡ERROR!",
                text: "¡Debes escribir algo!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })

        } else {

            const msgData = {
                idAlumno: idAlumno,
                chatInput: chatInput
            };

            $.ajax({
                url: urlPrincipal + "ajax/chat.ajax.php",
                method: "POST",
                data: msgData,
                dataType: "json",
                success: function (respuesta) {
                    console.log(respuesta); // Verifica la respuesta aquí
                    if (respuesta) {
                        conn.send(JSON.stringify(respuesta));
                        document.querySelector('.chat-input').value = '';
                    }
                    scrollToBottom()
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });

        }

    }

});