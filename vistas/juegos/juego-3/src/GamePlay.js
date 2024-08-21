GamePlayManager = {
    init: function () {

        game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        game.scale.pageAlignHorizontally = true;
        game.scale.pageAlignVertically = true;
        game.stage.disableVisibilityChange = true;

        this.endGame = false;

    },
    preload: function () {

        game.load.image('background', 'juegos/juego-3/assets/images/background4.jpeg');
        // game.load.image('background', 'assets/images/3.png');

        game.load.image('ball', 'juegos/juego-3/assets/images/ball3.png');
        game.load.image('ball2', 'juegos/juego-3/assets/images/ball4.png');

        // game.load.spritesheet('explosiones', 'assets/images/siones.png', 190, 194, 3);
        game.load.spritesheet('explosiones', 'juegos/juego-3/assets/images/rayo2.png', 246, 214, 4);

        // game.load.spritesheet('rayos', 'assets/images/rayo2.png', 246, 214, 4);

        game.load.audio('rayo', 'juegos/juego-3/assets/sounds/rayos.wav');
        game.load.audio('error', 'juegos/juego-3/assets/sounds/error.wav');

        game.load.image('mira', 'juegos/juego-3/assets/images/mira.png');

        //===========================================
        //BOTONES FUNCIONALES
        //===========================================
        game.load.image('btn1', 'juegos/juego-3/assets/images/btn1.png');
        game.load.image('btn2', 'juegos/juego-3/assets/images/btn2.png');
        game.load.image('btn3', 'juegos/juego-3/assets/images/btn3.png');
        game.load.image('btn4', 'juegos/juego-3/assets/images/btn4.png');

    },
    create: function () {

        // BACKGROUND
        this.background = game.add.sprite(0, 0, 'background');
        this.background.scale.setTo(1);

        //===========================================
        //BOTNOES FUNCIONALES
        //===========================================
        this.btnPause = game.add.sprite(1360, 120, 'btn1');
        this.btnPause.smoothed = true;
        this.btnPause.anchor.setTo(0.5)
        this.btnPause.scale.setTo(0.5, 0.5);

        this.btnExit = game.add.sprite(1360, 195, 'btn4');
        this.btnExit.smoothed = true;
        this.btnExit.anchor.setTo(0.5)
        this.btnExit.scale.setTo(0.5, 0.5);

        this.addClickEvent(this.btnPause, function () {

            game.paused = true;
            this.btnPause.visible = false;
            this.btnExit.visible = false;

            // Crear el botón de continuar
            this.btnContinue = game.add.sprite(1360, 120, 'btn2');
            this.btnContinue.smoothed = true;
            this.btnContinue.anchor.setTo(0.5);
            this.btnContinue.scale.setTo(0.5, 0.5);

            // Llama a la función para agregar eventos de clic al botón de continuar
            this.addClickEvent(this.btnContinue, function () {

                game.paused = false;
                this.btnContinue.visible = false; // Ocultar el botón de continuar
                this.btnPause.visible = true; // Mostrar el botón de pausa
                this.btnExit.visible = true;

            }.bind(this));

        }.bind(this));

        this.addClickEvent(this.btnExit, function () {

            if (this.logMMR(this.currentScore) != 0) {

                game.paused = true;

                var confirmExit = window.confirm("Si sales ahora, se aumentará: " + this.logMMR(this.currentScore) + " puntos de MMR ¿Estás seguro de que quieres salir?");

                if (confirmExit) {
                    this.enviarDatosPartida(this.currentScore)
                    history.back();
                } else {
                    game.paused = false;
                }

            } else {
                history.back();
            }

        });

        this.scaleIncrement = 0.005;
        this.maxScale = 0.5;
        this.currentScale = 0.3;

        //===========================================
        //SUMA
        //===========================================
        var style = {
            font: 'bold 30pt Arial',
            fill: '#ffffff',
            align: 'center'
        };

        // Crear el texto para mostrar la suma
        this.sumaText = game.add.text(1295, 20, '', style);
        this.sumaText.scale.setTo(1.1);

        // Generar una suma con un rango entre 5 y 10
        var respuestas = this.generarSuma(0, 10);

        // Puedes usar respuestas.correcta y respuestas.falsa como quieras
        console.log('Respuesta correcta:', respuestas.correcta);
        console.log('Respuesta falsa:', respuestas.falsa);

        // Activar el sistema de física arcade
        game.physics.startSystem(Phaser.Physics.ARCADE);

        //===========================================
        //BALLS
        //===========================================
        this.crearBalls(respuestas.correcta, respuestas.falsa)

        // Crear la pared derecha
        this.rightBound = game.add.sprite(1280, 0, '');
        game.physics.arcade.enable(this.rightBound);
        this.rightBound.width = 1;
        this.rightBound.height = 690;
        this.rightBound.body.immovable = true;

        // Variables para manejar el aumento de velocidad
        this.speedBoostDuration = 3000; // Duración del aumento en ms (3 segundos)
        this.speedBoostMultiplier = 1.5; // Multiplicador para el aumento de velocidad
        this.boostTimer = null;

        // game.canvas.style.cursor = 'none';

        //===========================================
        //EXPLOSIONES
        //===========================================
        this.explosionGroup = game.add.group();

        for (var i = 0; i < 10; i++) {
            this.explosion = this.explosionGroup.create(100, 100, 'explosiones');

            this.explosion.tweenScale = game.add.tween(this.explosion.scale).to({
                x: [1, 1.5, 1],
                y: [1, 1.5, 1]
            }, 1500, Phaser.Easing.Exponential.Out, false, 0, 0, false);

            this.explosion.tweenAlpha = game.add.tween(this.explosion).to({
                alpha: [1, 0.5, 0]
            }, 1500, Phaser.Easing.Exponential.Out, false, 0, 0, false);

            this.explosion.animations.add('animacionExplosiones', [0, 1, 2, 3, 3, 3], 25, false);

            this.explosion.anchor.setTo(0.5);
            this.explosion.kill();
        }

        //===========================================
        //SCORE
        //===========================================
        this.currentScore = 0;
        var style = {
            font: 'bold 30pt Arial',
            fill: '#ffffff',
            align: 'center'
        }
        this.scoreText = game.add.text(1360, 275, '0', style);
        this.scoreText.anchor.setTo(0.5);
        this.scoreText.scale.setTo(1.2)

        //===========================================
        //TIMER
        //===========================================
        var style = {
            font: 'bold 30pt Arial',
            fill: '#ffffff',
            align: 'center'
        }
        this.totalTime = 60;
        this.timerText = game.add.text(1360, 345, this.totalTime + '', style);
        this.timerText.anchor.setTo(0.5);

        this.timerGameOver = game.time.events.loop(Phaser.Timer.SECOND, function () {
            this.totalTime--;
            this.timerText.text = this.totalTime + '';
            if (this.totalTime <= 0) {
                game.time.events.remove(this.timerGameOver);
                this.endGame = true;
                this.showFinalMessage('Fin del juego');
                this.btnPause.visible = false;
                this.btnExit.visible = false;
            }
        }, this)

    },
    showFinalMessage: function (msg) {

        var bgAlpha = game.add.bitmapData(game.width, game.height);
        bgAlpha.ctx.fillStyle = '#000000';
        bgAlpha.ctx.fillRect(0, 0, game.width, game.height);

        var bg = game.add.sprite(0, 0, bgAlpha);
        bg.alpha = 0.6;

        var style = {
            font: 'bold 50pt Arial',
            fill: '#ffffff',
            align: 'center'
        }

        this.textFieldFinalMsg = game.add.text(game.width / 2, 200, msg, style);
        this.textFieldFinalMsg.anchor.setTo(0.5);

        this.finalScore = game.add.text(game.width / 2, 300, "Puntaje: " + this.currentScore, style);
        this.finalScore.anchor.setTo(0.5);

        this.puntos = this.currentScore / 10

        this.puntosFinales = game.add.text(game.width / 2, 400, "MMR: " + this.logMMR(this.currentScore), style);
        this.puntosFinales.anchor.setTo(0.5);

        //===========================================
        //BOTON AGAIN y EXIT
        //===========================================
        this.btnAgain = game.add.sprite(game.width / 2 - 110, 520, 'btn3');
        this.btnAgain.smoothed = true;
        this.btnAgain.anchor.setTo(0.5)
        this.btnAgain.scale.setTo(0.7, 0.7);

        this.btnExit2 = game.add.sprite(game.width / 2 + 110, 520, 'btn4');
        this.btnExit2.smoothed = true;
        this.btnExit2.anchor.setTo(0.5)
        this.btnExit2.scale.setTo(0.7, 0.7);

        this.addClickEvent(this.btnAgain, function () {

            game.state.start('gameplay');

        });

        this.addClickEvent(this.btnExit2, function () {

            history.back();

        });

        //===========================================
        //AJAX INSERTAR PARTIDA
        //===========================================
        if (this.logMMR(this.currentScore) != 0) {

            this.enviarDatosPartida(this.currentScore)

        }

    },
    //===========================================
    //BOTONES FUNCIONALES 
    //===========================================
    addClickEvent: function (button, callback) {
        button.inputEnabled = true;
        button.events.onInputDown.add(callback, this);
    },
    moverShot: function (shot, x, y) {

        var tweenMove = game.add.tween(shot).to({ x: x, y: y }, 150, Phaser.Easing.Linear.None);
        tweenMove.start();

    },
    render: function () {

        // game.debug.spriteBounds(this.ball1);
        // game.debug.spriteBounds(this.ball2);

    },
    crearBalls: function (num1, num2) {
        // Determinar cuál número será la respuesta correcta y cuál será la falsa
        var values = [num1, num2];
        var isBall1Correct = game.rnd.pick(values) === num1;

        this.correctAnswer = num1; // Definir la respuesta correcta

        var text1 = isBall1Correct ? num1 : num2;
        var text2 = isBall1Correct ? num2 : num1;

        // PRIMERA BOLA
        this.ball1 = game.add.sprite(game.rnd.integerInRange(0, 500), game.rnd.integerInRange(0, 689), 'ball');
        this.ball1.scale.setTo(0.35);
        this.ball1.anchor.setTo(0.5);
        game.physics.arcade.enable(this.ball1);
        this.ball1.body.collideWorldBounds = true;
        this.ball1.body.bounce.set(1);
        this.ball1.body.velocity.set(300, 300);

        var text = game.add.text(0, 0, text1, {
            font: 'bold 200pt Arial',
            fill: '#ffffff',
            align: 'center'
        });
        text.anchor.setTo(0.5);
        this.ball1.addChild(text);

        // Hacer que la bola sea clicable
        this.ball1.inputEnabled = true;
        this.ball1.events.onInputDown.add(this.bloqueClickeado, this);

        // SEGUNDA BOLA
        this.ball2 = game.add.sprite(game.rnd.integerInRange(600, 1000), game.rnd.integerInRange(0, 689), 'ball2');
        this.ball2.scale.setTo(0.35);
        this.ball2.anchor.setTo(0.5);
        game.physics.arcade.enable(this.ball2);
        this.ball2.body.collideWorldBounds = true;
        this.ball2.body.bounce.set(1);
        this.ball2.body.velocity.set(300, 300);

        var text2Elem = game.add.text(0, 0, text2, {
            font: 'bold 200pt Arial',
            fill: '#ffffff',
            align: 'center'
        });
        text2Elem.anchor.setTo(0.5);
        this.ball2.addChild(text2Elem);

        // Hacer que la bola sea clicable
        this.ball2.inputEnabled = true;
        this.ball2.events.onInputDown.add(this.bloqueClickeado, this);

        // MIRA
        // this.mira = game.add.sprite(0, 0, 'mira');
        // this.mira.scale.setTo(.3);
        // this.mira.anchor.setTo(0.5);
        // this.mira.bringToTop();
    },
    // Función para aumentar la velocidad
    boostBall: function (ball) {
        // Establecer la velocidad incrementada
        ball.body.velocity.x *= this.speedBoostMultiplier;
        ball.body.velocity.y *= this.speedBoostMultiplier;

        // Crear un temporizador para revertir la velocidad después de la duración
        if (!this.boostTimer) {
            this.boostTimer = game.time.create(false);
        }
        this.boostTimer.add(this.speedBoostDuration, function () {
            ball.body.velocity.x /= this.speedBoostMultiplier;
            ball.body.velocity.y /= this.speedBoostMultiplier;
        }, this);
        this.boostTimer.start();
    },
    increaseSpeed: function (ball) {
        // Generar un cambio aleatorio de velocidad entre -150 y 150
        let changeX = Math.random() * 600 - 300;
        let changeY = Math.random() * 600 - 300;

        // Aplicar el cambio de velocidad
        ball.body.velocity.x += changeX;
        ball.body.velocity.y += changeY;

        // Limitar la velocidad a 600
        if (Math.abs(ball.body.velocity.x) > 600) {
            ball.body.velocity.x = 600 * Math.sign(ball.body.velocity.x);
        }
        if (Math.abs(ball.body.velocity.y) > 600) {
            ball.body.velocity.y = 600 * Math.sign(ball.body.velocity.y);
        }
    },
    bloqueClickeado: function (sprite, pointer) {

        if (!this.endGame && game.paused == false) {

            // Capturar el número del bloque clickeado
            var clickedNumber = parseInt(sprite.children[0].text);
            console.log(clickedNumber)
            console.log(this.correctAnswer)

            // Verificar si el número clickeado es igual a la respuesta correcta
            if (clickedNumber === this.correctAnswer) {
                console.log("RESPUESTA CORRECTA");
                this.currentScore += 100;

                this.scoreText.scoreTween = game.add.tween(this.scoreText.scale).to({
                    x: [1.2, 2, 1.2],
                    y: [1.2, 2, 1.2]
                }, 600, Phaser.Easing.Exponential.Out, false, 0, 0, false);

                this.scoreText.text = this.currentScore;

                this.scoreText.scoreTween.start()

                // Posicionar la explosión en la posición del sprite clickeado
                var explosion = this.explosionGroup.getFirstExists(false);
                explosion.reset(sprite.x, sprite.y);

                // Reproducir la animación de la explosión
                explosion.revive();
                explosion.animations.play('animacionExplosiones');
                explosion.tweenScale.start();
                explosion.tweenAlpha.start();

                var explosionSound = this.sound.add('rayo')
                explosionSound.volume = 0.5;
                explosionSound.play();

                // Destruir ambas bolas
                this.ball1.destroy();
                this.ball2.destroy();
                // this.mira.destroy();

                // Ejecutar el código para crear nuevas bolas después de que la animación termine
                explosion.tweenAlpha.onComplete.addOnce(function () {
                    explosion.kill(); // Ocultar la explosión después de la animación

                    var respuestas = this.generarSuma(5, 10); // Cambia el rango según tu necesidad
                    this.crearBalls(respuestas.correcta, respuestas.falsa);

                }, this);

            } else {
                console.log("RESPUESTA INCORRECTA");
                this.currentScore -= 100;

                sprite.tweenError = game.add.tween(sprite.scale).to({
                    x: [0.5, 0.6, 0.5, 0.6, 0.5],
                    y: [0.5, 0.6, 0.5, 0.6, 0.5]
                }, 1000, Phaser.Easing.Exponential.Out, false, 0, 0, false);
                sprite.tweenError.start();

                this.scoreText.scoreTween = game.add.tween(this.scoreText.scale).to({
                    x: [1.2, 2, 1.2],
                    y: [1.2, 2, 1.2]
                }, 600, Phaser.Easing.Exponential.Out, false, 0, 0, false);

                var colorTween = game.add.tween(this.scoreText).to({ tint: 0xff0000 }, 600, Phaser.Easing.Linear.None, false, 0, 0, false);

                this.scoreText.text = this.currentScore;
                colorTween.start();
                colorTween.onComplete.add(function () {
                    this.scoreText.tint = 0xffffff;
                }, this);
                this.scoreText.scoreTween.start()

                var explosionSound = this.sound.add('error')
                explosionSound.volume = 0.5;
                explosionSound.play();

                // Verificar si la animación ya se ha ejecutado
                if (!sprite.hasAnimated) {
                    // Reproducir sonido de error
                    var explosionSound = this.sound.add('error');
                    explosionSound.volume = 0.5;
                    explosionSound.play();

                    // Animar aumento de tamaño
                    sprite.tweenError = game.add.tween(sprite.scale).to({
                        x: [0.3, 0.5, 0.3, 0.5, 0.8],
                        y: [0.3, 0.5, 0.3, 0.5, 0.8]
                    }, 1000, Phaser.Easing.Exponential.Out, false, 0, 0, false);
                    sprite.tweenError.start();

                    // Marcar como animado para evitar futuras animaciones
                    sprite.hasAnimated = true;

                } else {

                    // Animar aumento de tamaño
                    sprite.tweenError = game.add.tween(sprite.scale).to({
                        x: [0.8, 0.6, 0.8, 0.6, 0.8],
                        y: [0.8, 0.6, 0.8, 0.6, 0.8]
                    }, 1000, Phaser.Easing.Exponential.Out, false, 0, 0, false);
                    sprite.tweenError.start();

                }
            }

        }

    },
    generarSuma: function (rangoMin, rangoMax) {
        // Generar dos números aleatorios en el rango de rangoMin a rangoMax
        var num1 = game.rnd.integerInRange(rangoMin, rangoMax);
        var num2 = game.rnd.integerInRange(rangoMin, rangoMax);

        // Calcular la respuesta correcta
        var respuestaCorrecta = num1 + num2;

        // Generar una respuesta falsa
        var respuestaFalsa;
        do {
            // Respuesta falsa dentro de un rango razonable, evitando valores descabellados
            respuestaFalsa = game.rnd.integerInRange(respuestaCorrecta - 10, respuestaCorrecta + 10);
        } while (respuestaFalsa === respuestaCorrecta || respuestaFalsa < rangoMin * 2 || respuestaFalsa > rangoMax * 2);

        // Actualizar el texto con la suma
        this.sumaText.setText(num1 + ' + ' + num2);

        // Devolver las respuestas para su uso
        return {
            correcta: respuestaCorrecta,
            falsa: respuestaFalsa
        };
    },
    update: function () {

        // Actualiza la posición de la mira para que siga al cursor
        // this.mira.x = game.input.x;
        // this.mira.y = game.input.y;

        // Asegúrate de que la mira no quede fuera de los límites del juego si es necesario
        // Esto es opcional y depende del tamaño de la mira y del área de juego
        // if (this.mira.x < 0) {
        //     this.mira.x = 0;
        // }
        // if (this.mira.y < 0) {
        //     this.mira.y = 0;
        // }
        // if (this.mira.x > game.width) {
        //     this.mira.x = game.width;
        // }
        // if (this.mira.y > game.height) {
        //     this.mira.y = game.height;
        // }


        game.physics.arcade.collide(this.ball1, this.ball2, function () {
            // console.log('CHOQUE');

        }, null, this);

        // Colisiones con las paredes
        if (this.ball1 && this.ball1.body) {
            if (this.ball1.body.position.y <= 0 || this.ball1.body.position.y >= 690) {
                this.increaseSpeed(this.ball1);
            }
            if (this.ball1.body.position.x <= 0 || this.ball1.body.position.x >= 1280) {
                this.increaseSpeed(this.ball1);
            }
        }

        if (this.ball2 && this.ball2.body) {
            if (this.ball2.body.position.y <= 0 || this.ball2.body.position.y >= 690) {
                this.increaseSpeed(this.ball2);
            }
            if (this.ball2.body.position.x <= 0 || this.ball2.body.position.x >= 1280) {
                this.increaseSpeed(this.ball2);
            }
        }

        // Colisiones con la pared invisible derecha
        if (this.ball1 && this.ball1.body) {
            game.physics.arcade.collide(this.ball1, this.rightBound, function () {
                this.increaseSpeed(this.ball1);
            }, null, this);
        }

        if (this.ball2 && this.ball2.body) {
            game.physics.arcade.collide(this.ball2, this.rightBound, function () {
                this.increaseSpeed(this.ball2);
            }, null, this);
        }

    },

    //===========================================
    //CONFIGURANDO EL MMR
    //===========================================
    logMMR: function (puntaje) {
        if (puntaje >= 100) {
            let centena = Math.floor(puntaje / 100) * 100;
            return centena / 10;
        } else if (puntaje <= -100) {
            let centena = Math.ceil(puntaje / 100) * 100;
            return centena / 10;
        } else {
            return 0;
        }
    },

    //===========================================
    //ENVIAR DATOS DE PARTIDA
    //===========================================
    enviarDatosPartida: function (currentScore) {
        var idAlumno = $("#idAlumno").val();

        if (idAlumno != "invitado") {

            var idJuego = 3;
            var puntajeJuego = currentScore;
            var mmr_cambio = this.logMMR(this.currentScore);

            var datos = new FormData();
            datos.append("idAlumno", idAlumno);
            datos.append("idJuego", idJuego);
            datos.append("puntajeJuego", puntajeJuego);
            datos.append("mmr_cambio", mmr_cambio);

            $.ajax({
                url: urlPrincipal + "ajax/partidas.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta) {
                        console.log(respuesta);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });

        } else {

            console.log("MODO INVITADO")

        }

    }
}

var game = new Phaser.Game(1450, 690, Phaser.CANVAS);

game.state.add("gameplay", GamePlayManager);
game.state.start("gameplay");
