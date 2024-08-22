var INICIO = 0;
var FIN = 15;

var PUNTAJEFINAL = 0

function obtenerModoAleatorio() {
    // Array con los posibles valores
    var modos = ['ascendente', 'descendente'];
    // Selecciona un índice aleatorio del array
    var indiceAleatorio = Math.floor(Math.random() * modos.length);
    // Retorna el valor correspondiente
    return modos[indiceAleatorio];
}

// Asigna el valor aleatorio a la variable MODO
var MODO = obtenerModoAleatorio();

GamePlayManager = {
    init: function () {
        game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        game.scale.pageAlignHorizontally = true;
        game.scale.pageAlignVertically = true;
        game.stage.disableVisibilityChange = true;

        this.endGame = false;
    },
    preload: function () {
        game.load.image('background', 'juegos/juego-1/assets/images/background2.png');

        game.load.spritesheet('meteoros', 'juegos/juego-1/assets/images/meteoros.png', 248, 450, 4);

        game.load.spritesheet('astrom', 'juegos/juego-1/assets/images/astrom.png', 270, 479, 4);

        game.load.spritesheet('siones', 'juegos/juego-1/assets/images/siones.png', 190, 194, 3);

        game.load.image('shot', 'juegos/juego-1/assets/images/shot2.png');

        game.load.audio('disparo', 'juegos/juego-1/assets/sounds/disparo.wav');
        game.load.audio('explosion', 'juegos/juego-1/assets/sounds/explosion.wav');
        game.load.audio('error', 'juegos/juego-1/assets/sounds/error.wav');

        //===========================================
        //BOTONES FUNCIONALES
        //===========================================
        game.load.image('btn1', 'juegos/juego-1/assets/images/btn1.png');
        game.load.image('btn2', 'juegos/juego-1/assets/images/btn2.png');
        game.load.image('btn3', 'juegos/juego-1/assets/images/btn3.png');
        game.load.image('btn4', 'juegos/juego-1/assets/images/btn4.png');
    },
    create: function () {
        game.add.sprite(0, 0, 'background');

        //===========================================
        //BOTNOES FUNCIONALES
        //===========================================
        this.btnPause = game.add.sprite(1040, 220, 'btn1');
        this.btnPause.smoothed = true;
        this.btnPause.anchor.setTo(0.5)
        this.btnPause.scale.setTo(0.5, 0.5);

        this.btnExit = game.add.sprite(1040, 290, 'btn4');
        this.btnExit.smoothed = true;
        this.btnExit.anchor.setTo(0.5)
        this.btnExit.scale.setTo(0.5, 0.5);

        this.addClickEvent(this.btnPause, function () {

            game.paused = true;
            this.btnPause.visible = false;
            this.btnExit.visible = false;

            // Crear el botón de continuar
            this.btnContinue = game.add.sprite(1040, 220, 'btn2');
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

        //===========================================
        //ASTROM
        //===========================================
        this.astrom = game.add.sprite(1035, 460, 'astrom');
        this.astrom.smoothed = true;
        this.astrom.anchor.setTo(0.5)

        this.astrom.scale.setTo(-0.6, 0.6);

        var animations = this.astrom.animations.add('animaciondos', [3, 0, 1, 3, 1, 0], 20, false);

        //===========================================
        //METEORITOS
        //===========================================
        this.meteoritos = [];
        this.crearMeteoritos();

        //===========================================
        //EXPLOSIONES
        //===========================================
        this.explosionGroup = game.add.group();

        for (var i = 0; i < 10; i++) {
            this.explosion = this.explosionGroup.create(100, 100, 'siones');

            this.explosion.tweenScale = game.add.tween(this.explosion.scale).to({
                x: [1, 1.5, 1],
                y: [1, 1.5, 1]
            }, 800, Phaser.Easing.Exponential.Out, false, 0, 0, false);

            this.explosion.tweenAlpha = game.add.tween(this.explosion).to({
                alpha: [1, 0.6, 0]
            }, 800, Phaser.Easing.Exponential.Out, false, 0, 0, false);

            this.explosion.animations.add('animacionSiones', [0, 1, 2, 0, 1, 2], 18, false);

            this.explosion.anchor.setTo(0.5);
            this.explosion.kill();
        }

        //===========================================
        //HUMO DE ARMA
        //===========================================
        this.humoGroup = game.add.group();

        for (var i = 0; i < 10; i++) {
            this.humo = this.humoGroup.create(920, 365, 'siones');

            this.humo.tweenScale = game.add.tween(this.humo.scale).to({
                x: [0.4, 0.6, 0.4],
                y: [0.4, 0.6, 0.4]
            }, 1000, Phaser.Easing.Exponential.Out, false, 0, 0, false);

            this.humo.tweenAlpha = game.add.tween(this.humo).to({
                alpha: [1, 0.6, 0]
            }, 1000, Phaser.Easing.Exponential.Out, false, 0, 0, false);

            this.humo.animations.add('animacionHumo', [0, 1, 2, 0, 1, 2], 18, false);

            this.humo.anchor.setTo(0.5);
            this.humo.kill();
        }

        //===========================================
        //SHOT
        //===========================================
        this.shotGroup = game.add.group();

        for (var i = 0; i < 10; i++) {
            this.shot = this.shotGroup.create(920, 365, 'shot');
            this.shot.scale.setTo(-0.8, 0.8);

            this.shot.tweenAlpha = game.add.tween(this.shot).to({
                alpha: [1, 0.6, 0]
            }, 500, Phaser.Easing.Exponential.Out, false, 0, 0, false);

            this.shot.anchor.setTo(0.5);
            this.shot.kill();
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
        this.scoreText = game.add.text(1035, 70, '0', style);
        this.scoreText.anchor.setTo(0.5);
        this.scoreText.scale.setTo(1.2)

        //===========================================
        //MODO
        //===========================================
        var style = {
            font: 'bold 20pt Arial',
            fill: '#ffffff',
            align: 'center'
        }
        this.modoText = game.add.text(game.width / 2, 40, MODO, style);
        this.modoText.anchor.setTo(0.5);
        this.modoText.scale.setTo(1.2)

        //===========================================
        //TIMER
        //===========================================
        var style = {
            font: 'bold 30pt Arial',
            fill: '#ffffff',
            align: 'center'
        }
        this.totalTime = 60;
        this.timerText = game.add.text(1035, 150, this.totalTime + '', style);
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
            MODO = obtenerModoAleatorio();

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
    generarArregloDesordenado: function (inicio, fin) {
        var arreglo = [];
        var numeroInicial = game.rnd.integerInRange(inicio, fin - 3);
        for (var i = 0; i < 4; i++) {
            var numero = (numeroInicial + i)
            arreglo.push(numero);
        }
        return Phaser.ArrayUtils.shuffle(arreglo);
    },
    bloqueClickeado: function (sprite, pointer) {

        console.log(parseInt(sprite.texto.text));

        if (!this.endGame && game.paused == false) {
            if (parseInt(sprite.texto.text) === this.numerosOrdenados[0]) {

                //===========================================
                //SCORE
                //===========================================
                this.currentScore += 25;
                PUNTAJEFINAL += 25;

                this.scoreText.scoreTween = game.add.tween(this.scoreText.scale).to({
                    x: [1.2, 2, 1.2],
                    y: [1.2, 2, 1.2]
                }, 600, Phaser.Easing.Exponential.Out, false, 0, 0, false);

                this.scoreText.text = this.currentScore;

                this.scoreText.scoreTween.start()

                this.numerosOrdenados.shift();

                this.astrom.animations.play('animaciondos');
                sprite.destroy();

                //===========================================
                //EXPLOSION METEORO
                //===========================================
                var explosion = this.explosionGroup.getFirstDead();
                if (explosion != null) {
                    explosion.reset(sprite.x, sprite.y);
                    explosion.animations.play('animacionSiones');
                    explosion.tweenScale.start();
                    explosion.tweenAlpha.start();

                    explosion.tweenAlpha.onComplete.add(function (currentTarget, currentTween) {
                        currentTarget.kill();
                    }, this);
                }

                //===========================================
                //HUMO ARMA
                //===========================================
                var disparoSound = this.sound.add('disparo')
                disparoSound.volume = 0.8;
                disparoSound.play();

                var humo = this.humoGroup.getFirstDead();
                if (humo != null) {
                    humo.reset(960, 395);
                    humo.scale.setTo(0.3);
                    humo.animations.play('animacionHumo');
                    humo.tweenScale.start();
                    humo.tweenAlpha.start();

                    humo.tweenAlpha.onComplete.add(function (currentTarget, currentTween) {
                        currentTarget.kill();
                    }, this);
                }

                //===========================================
                //SHOT
                //===========================================
                var shot = this.shotGroup.getFirstDead();
                if (shot != null) {
                    shot.reset(960, 395);
                    shot.scale.setTo(-0.3, 0.3);
                    shot.tweenAlpha.start();

                    this.moverShot(shot, sprite.x, sprite.y);

                    shot.tweenAlpha.onComplete.add(function (currentTarget, currentTween) {
                        currentTarget.kill();
                    }, this);
                }

                //===========================================
                //ELIMINAR EL METEORO DEL ARRAY
                //===========================================
                var index = this.meteoritos.indexOf(sprite);
                if (index !== -1) {
                    this.meteoritos.splice(index, 1);
                }

                sprite.events.onInputDown.removeAll();

            } else {

                this.currentScore -= 25;
                PUNTAJEFINAL -= 25;
                var errorSound = this.sound.add('error')
                errorSound.play();

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
            }
        } else {
            return;
        }
    },
    moverShot: function (shot, x, y) {
        var tweenMove = game.add.tween(shot).to({ x: x, y: y }, 150, Phaser.Easing.Linear.None);
        tweenMove.start();
    },
    crearMeteoritos: function () {
        this.numeros = this.generarArregloDesordenado(INICIO, FIN);
        if (MODO === 'ascendente') {
            this.numerosOrdenados = this.numeros.slice().sort((a, b) => a - b);
        } else {
            this.numerosOrdenados = this.numeros.slice().sort((a, b) => b - a);
        }

        //===========================================
        //CREAR 4 METEOROS
        //===========================================
        for (var i = 0; i < 4; i++) {
            var diamond = game.add.sprite(100, 100, 'meteoros');
            diamond.frame = i;
            diamond.scale.setTo(0.5);
            diamond.anchor.setTo(0.5);
            diamond.x = game.rnd.integerInRange(100, 850);
            diamond.y = -100;
            diamond.vel = game.rnd.integerInRange(4, 6);
            diamond.texto = game.add.text(0, 100, this.numeros[i],
                {
                    font: 'bold 75pt Arial',
                    fill: '#000000',
                    align: 'center'
                }
            );
            diamond.texto.anchor.setTo(0.5);
            diamond.addChild(diamond.texto);

            this.meteoritos[i] = diamond;

            //===========================================
            //COLISION EN EL EJE X ENTRE METEOROS
            //===========================================
            var rectCurrenDiamond = this.getBoundsDiamond(diamond);
            while (this.isOverlapingOtherDiamond(i, rectCurrenDiamond)) {
                diamond.x = game.rnd.integerInRange(100, 850);
                rectCurrenDiamond = this.getBoundsDiamond(diamond);
            }

            //===========================================
            //TWEEN CAIDA INFINITA
            //===========================================
            var tweenBloqueGo = game.add.tween(diamond);
            var velocidades = [8000, 9000, 10000, 11000];
            var indice = game.rnd.integerInRange(0, 3)
            tweenBloqueGo.to({ y: 680 }, velocidades[indice], Phaser.Easing.Linear.None);
            tweenBloqueGo.start();

            // Callback al completar la animación de caída
            tweenBloqueGo.onComplete.add(function (meteorito) {
                return function () {
                    // Obtener el índice del meteorito actual en el array this.meteoritos
                    var indice = this.meteoritos.indexOf(meteorito);
                    // Eliminar el meteorito del array
                    if (indice !== -1) {
                        this.meteoritos.splice(indice, 1);

                        if (!this.endGame) {
                            this.currentScore -= 25;

                            meteorito.tweenError = game.add.tween(meteorito.scale).to({
                                x: [0.5, 0.6, 0.5, 0.6, 0.5],
                                y: [0.5, 0.6, 0.5, 0.6, 0.5]
                            }, 1000, Phaser.Easing.Exponential.Out, false, 0, 0, false);
                            meteorito.tweenError.start();

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
                            var explosionSound = this.sound.add('explosion')
                            explosionSound.volume = 0.5;
                            explosionSound.play();
                        }
                    }
                    // Destruir el sprite del meteorito
                    meteorito.destroy();

                    var explosion = this.explosionGroup.getFirstDead();
                    if (explosion != null) {
                        explosion.reset(meteorito.x, meteorito.y);
                        explosion.animations.play('animacionSiones');
                        explosion.tweenScale.start();
                        explosion.tweenAlpha.start();

                        explosion.tweenAlpha.onComplete.add(function (currentTarget, currentTween) {
                            currentTarget.kill();
                        }, this);
                    }

                };
            }(diamond), this);

        }
    },
    getBoundsDiamond: function (currentDiamond) {
        return new Phaser.Rectangle(currentDiamond.left, currentDiamond.top, currentDiamond.width, currentDiamond.height);
    },
    isRectanglesOverlapping: function (rect1, rect2) {
        if (rect1.x > rect2.x + rect2.width || rect1.x + rect1.width < rect2.x) {
            return false;
        }
        return true;
    },
    isOverlapingOtherDiamond: function (index, rect2) {
        for (var i = 0; i < index; i++) {
            var rect1 = this.getBoundsDiamond(this.meteoritos[i]);
            if (this.isRectanglesOverlapping(rect1, rect2)) {
                return true;
            }
        }
        return false;
    },
    render: function () {

    },
    update: function () {

        if (this.meteoritos.length <= 0 && !this.endGame) {
            this.crearMeteoritos();
        }

        for (var i = 0; i < this.meteoritos.length; i++) {
            if (!this.meteoritos[i].clicked) {
                this.meteoritos[i].inputEnabled = true;
                this.meteoritos[i].events.onInputDown.add(this.bloqueClickeado, this);
                this.meteoritos[i].clicked = true;
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
            var idJuego = 1;
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
