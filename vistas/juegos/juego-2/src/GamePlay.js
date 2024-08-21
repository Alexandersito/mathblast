GamePlayManager = {
    init: function () {
        game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        game.scale.pageAlignHorizontally = true;
        game.scale.pageAlignVertically = true;
        game.stage.disableVisibilityChange = true;

        this.endGame = false;
    },
    preload: function () {
        game.load.image('background', 'juegos/juego-2/assets/images/background.png');
        game.load.image('block', 'juegos/juego-2/assets/images/block.png');

        game.load.spritesheet('penguin', 'juegos/juego-2/assets/images/penguin.png', 373, 433, 4);

        game.load.audio('error', 'juegos/juego-2/assets/sounds/error.wav');
        game.load.audio('correct', 'juegos/juego-2/assets/sounds/correct.wav');

        //===========================================
        //BOTONES FUNCIONALES
        //===========================================
        game.load.image('btn1', 'juegos/juego-2/assets/images/btn1.png');
        game.load.image('btn2', 'juegos/juego-2/assets/images/btn2.png');
        game.load.image('btn3', 'juegos/juego-2/assets/images/btn3.png');
        game.load.image('btn4', 'juegos/juego-2/assets/images/btn4.png');
    },
    create: function () {
        game.add.sprite(0, 0, 'background');

        //===========================================
        //BOTNOES FUNCIONALES
        //===========================================
        this.btnPause = game.add.sprite(1040, 280, 'btn4');
        this.btnPause.smoothed = true;
        this.btnPause.anchor.setTo(0.5)
        this.btnPause.scale.setTo(0.5, 0.5);

        this.btnExit = game.add.sprite(1040, 350, 'btn2');
        this.btnExit.smoothed = true;
        this.btnExit.anchor.setTo(0.5)
        this.btnExit.scale.setTo(0.5, 0.5);

        this.addClickEvent(this.btnPause, function () {

            game.paused = true;
            this.btnPause.visible = false;
            this.btnExit.visible = false;

            // Crear el botón de continuar
            this.btnContinue = game.add.sprite(1040, 280, 'btn3');
            this.btnContinue.smoothed = true;
            this.btnContinue.anchor.setTo(0.5);
            this.btnContinue.scale.setTo(0.5, 0.5);

            // Llama a la función para agregar eventos de clic al botón de continuar
            this.addClickEvent(this.btnContinue, function () {

                game.paused = false;
                this.btnContinue.visible = false; // Ocultar el botón de continuar
                this.btnPause.visible = true;
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

        //===========================================
        //COORDENADAS DE BLOQUES
        //===========================================
        this.blocks = [];
        var positions = [
            { x: 284, y: 200 }, { x: 468, y: 200 }, { x: 668, y: 200 }, { x: 852, y: 200 },
            { x: 284, y: 320 }, { x: 468, y: 320 }, { x: 668, y: 320 }, { x: 852, y: 320 },
            { x: 284, y: 440 }, { x: 468, y: 440 }, { x: 668, y: 440 }, { x: 852, y: 440 }
        ];

        for (var i = 0; i < positions.length; i++) {
            var block = game.add.sprite(positions[i].x, positions[i].y, 'block');
            block.anchor.setTo(0.5);
            block.scale.setTo(0.4);
            this.blocks[i] = block;
        }

        //===========================================
        //PENGUIN
        //===========================================
        this.penguin = game.add.sprite(568, 520, 'penguin');
        this.penguin.frame = 0;
        this.penguin.anchor.setTo(0.5)
        this.penguin.scale.setTo(0.2);

        var animation = this.penguin.animations.add('animacion', [0, 1, 2, 3], 6, false);

        //===========================================
        //GENERAR SUMA
        //===========================================
        this.style = {
            font: 'bold 30pt "Chicle Regular", cursive, sans-serif',
            fill: '#000000',
            align: 'center'
        }

        this.preguntar = game.add.text(game.width / 2, 70, '0', this.style);
        this.preguntar.anchor.setTo(0.5);

        this.alterativaA = game.add.text(284, 428, '10', this.style);
        this.alterativaA.anchor.setTo(0.5);

        this.alterativaB = game.add.text(468, 428, '20', this.style);
        this.alterativaB.anchor.setTo(0.5);

        this.alterativaC = game.add.text(668, 428, '30', this.style);
        this.alterativaC.anchor.setTo(0.5);

        this.alterativaD = game.add.text(852, 428, '30', this.style);
        this.alterativaD.anchor.setTo(0.5);

        var alternativas = this.generarSuma();
        this.alterativaA.text = alternativas[0]
        this.alterativaB.text = alternativas[1]
        this.alterativaC.text = alternativas[2]
        this.alterativaD.text = alternativas[3]

        //===========================================
        //SCORE
        //===========================================
        this.currentScore = 0;
        var style = {
            font: 'bold 30pt Arial',
            fill: '#ffffff',
            align: 'center'
        }
        this.scoreText = game.add.text(852, 70, '0', style);
        this.scoreText.anchor.setTo(0.5);
        this.scoreText.scale.setTo(1.2)

        //===========================================
        //TIMER
        //===========================================
        this.totalTime = 60;
        this.timerText = game.add.text(284, 70, this.totalTime + '', style);
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
        this.btnAgain = game.add.sprite(game.width / 2 - 110, 520, 'btn1');
        this.btnAgain.smoothed = true;
        this.btnAgain.anchor.setTo(0.5)
        this.btnAgain.scale.setTo(0.75, 0.75);

        this.btnExit2 = game.add.sprite(game.width / 2 + 110, 520, 'btn2');
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

    generarSuma: function () {
        //===========================================
        //NUMEROS ALEATORIOS
        //===========================================
        var num1 = game.rnd.integerInRange(1, 10);
        var num2 = game.rnd.integerInRange(1, 10);
        var respuesta = num1 + num2;
        // global
        this.respuesta = respuesta;

        var alternativas = [];
        alternativas.push(respuesta);

        // Generar otras dos alternativas incorrectas
        while (alternativas.length < 4) {
            var alternativa = Math.abs(game.rnd.integerInRange(respuesta - 5, respuesta + 5));
            if (alternativa !== respuesta && !alternativas.includes(alternativa)) {
                alternativas.push(alternativa);
            }
        }

        // Mezclar las alternativas para que no estén en el orden correcto
        alternativas.sort(function () { return Math.random() - 0.5 });

        // Crear la pregunta de suma
        var pregunta = num1 + " + " + num2;
        this.preguntar.text = pregunta;

        return alternativas;
    },
    bloqueClickeado: function (sprite, pointer) {

        if (!this.endGame && game.paused == false) {

            //===========================================
            //DETECTAR ALTERNATIVA MARCADA
            //===========================================
            var rpt
            if (sprite.x == 284) {
                rpt = parseInt(this.alterativaA.text)
            } if (sprite.x == 468) {
                rpt = parseInt(this.alterativaB.text)
            } if (sprite.x == 668) {
                rpt = parseInt(this.alterativaC.text)
            } if (sprite.x == 852) {
                rpt = parseInt(this.alterativaD.text)
            }

            //===========================================
            //COMPARAR ALTERNATIVA MARCADA Y LA RESPUESTA
            //===========================================
            if (this.respuesta == rpt) {
                this.currentScore += 40;

                this.scoreText.scoreTween = game.add.tween(this.scoreText.scale).to({
                    x: [1.2, 2, 1.2],
                    y: [1.2, 2, 1.2]
                }, 600, Phaser.Easing.Exponential.Out, false, 0, 0, false);

                this.scoreText.text = this.currentScore;

                this.scoreText.scoreTween.start()

                var correctSound = this.sound.add('correct')
                correctSound.play();

                var alternativas = this.generarSuma();
                this.alterativaA.text = alternativas[0]
                this.alterativaB.text = alternativas[1]
                this.alterativaC.text = alternativas[2]
                this.alterativaD.text = alternativas[3]

            } else {
                this.currentScore -= 40;

                sprite.tweenError = game.add.tween(sprite.scale).to({
                    x: [0.4, 0.5, 0.4, 0.5, 0.4],
                    y: [0.4, 0.5, 0.4, 0.5, 0.4]
                }, 2000, Phaser.Easing.Exponential.Out, false, 0, 0, false);
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

                var errorSound = this.sound.add('error')
                errorSound.play();

                return
            }

            //===========================================
            //BLOQUE DEL PENGUIN - ELIMINAR
            //===========================================
            var spriteAEliminar = null;
            game.world.forEach(function (sprite) {
                if (sprite.key === "block" && sprite.x === 568 && sprite.y === 560) {
                    spriteAEliminar = sprite;
                    var tweenSpriteEliminado = game.add.tween(spriteAEliminar)
                    tweenSpriteEliminado.to({ x: game.rnd.integerInRange(1, 1140), y: 700 }, 450, Phaser.Easing.Linear.None);
                    tweenSpriteEliminado.onComplete.add(function () {
                        spriteAEliminar.destroy();
                    }, this);
                    tweenSpriteEliminado.start();
                }
            });

            //===========================================
            //ELIMINAR EL BLOQUE DEL ARRAY y LOS OTROS DOS BLOQUES
            //===========================================
            var index = this.blocks.indexOf(sprite);
            if (index !== -1) {
                this.blocks.splice(index, 1);
                sprite.inputEnabled = false;
            }

            for (var i = 0; i < this.blocks.length; i++) {
                if (this.blocks[i].y === 440) {
                    this.blocks[i].destroy();
                    this.blocks.splice(i, 1);
                    i--;
                }
            }

            //===========================================
            //SALTO DEL PENGUIN
            //===========================================
            var tweenPenguinJump = game.add.tween(this.penguin);
            var jumpHeight = 80; // Altura máxima del salto
            var jumpDuration = 500; // Duración del salto
            tweenPenguinJump.to({ y: this.penguin.y - jumpHeight }, jumpDuration / 2, Phaser.Easing.Sinusoidal.Out);
            tweenPenguinJump.to({ y: this.penguin.y }, jumpDuration / 2, Phaser.Easing.Sinusoidal.In);
            tweenPenguinJump.start();
            this.penguin.animations.play('animacion');

            this.alterativaA.alpha = 0;
            this.alterativaB.alpha = 0;
            this.alterativaC.alpha = 0;
            this.alterativaD.alpha = 0;

            //===========================================
            //BLOQUE CLIKEADO - DESPLAZAMIENTO
            //===========================================
            var tweenBloqueGo = game.add.tween(sprite);
            tweenBloqueGo.to({ x: 568, y: 560 }, 420, Phaser.Easing.Linear.None);
            tweenBloqueGo.start();
            tweenBloqueGo.onComplete.add(function () {

                //===========================================
                //TWEEN BLOQUE DEBAJO DEL PENGUIN
                //===========================================
                var tweenRebote = game.add.tween(sprite.scale);
                var scaleFactor = 1.3; // Factor de escala para el rebote
                var duration = 300; // Duración del rebote en milisegundos
                tweenRebote.to({ x: sprite.scale.x * scaleFactor, y: sprite.scale.y * scaleFactor }, duration / 2);
                tweenRebote.to({ x: sprite.scale.x, y: sprite.scale.y }, duration / 2);
                tweenRebote.start();

                //===========================================
                //DESPLAZAMIENTO DE LAS 2 FILAS SUPERIORES
                //===========================================
                for (var i = 0; i < this.blocks.length; i++) {
                    if (this.blocks[i].y == 200 || this.blocks[i].y == 320) {
                        var tweenDesplazamiento = game.add.tween(this.blocks[i]);
                        tweenDesplazamiento.to({ y: this.blocks[i].y + 120 }, 500, Phaser.Easing.Linear.None);
                        tweenDesplazamiento.start();
                        tweenDesplazamiento.onComplete.add(function () {

                            //===========================================
                            //AGREGAR FILA NUEVA (3 BLOQUES) AL ARRAY
                            //===========================================
                            if (this.blocks.length === 8) {
                                var nuevasPosiciones = [
                                    { x: 284, y: 200 }, { x: 468, y: 200 }, { x: 668, y: 200 }, { x: 852, y: 200 }
                                ];

                                for (var i = 0; i < 4; i++) {
                                    var nuevoBloque = game.add.sprite(nuevasPosiciones[i].x, nuevasPosiciones[i].y, 'block');
                                    nuevoBloque.anchor.setTo(0.5);
                                    nuevoBloque.scale.setTo(0.4);
                                    // Z index de los nuevos bloques
                                    game.world.setChildIndex(nuevoBloque, 1);

                                    // Crear tween de alpha
                                    nuevoBloque.tweenAlpha = game.add.tween(nuevoBloque);
                                    nuevoBloque.tweenAlpha.to({ alpha: [0, 0.6, 1] }, 1500, Phaser.Easing.Exponential.Out, false, 0, 0, false);
                                    nuevoBloque.tweenAlpha.start();

                                    this.alterativaA.alpha = 1;
                                    this.alterativaB.alpha = 1;
                                    this.alterativaC.alpha = 1;
                                    this.alterativaD.alpha = 1;

                                    this.blocks.push(nuevoBloque);
                                }
                            }
                        }, this);
                    }
                }
            }, this);

            sprite.events.onInputDown.removeAll();
        }

    },
    render: function () {

    },
    update: function () {

        if (!this.endGame) {

            //===========================================
            //DETECTAR CLICK EN LOS BLOQUES DEL ARRAY PRINCIPAL
            //===========================================
            for (var i = 0; i < this.blocks.length; i++) {
                if (this.blocks[i].y == 440 && !this.blocks[i].clicked) {
                    this.blocks[i].inputEnabled = true;
                    this.blocks[i].events.onInputDown.add(this.bloqueClickeado, this);
                    this.blocks[i].clicked = true;
                }
            }
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

            var idJuego = 2;
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

var game = new Phaser.Game(1136, 640, Phaser.CANVAS);

game.state.add("gameplay", GamePlayManager);
game.state.start("gameplay");