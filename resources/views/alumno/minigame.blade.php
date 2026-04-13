<x-app-layout>
    <x-slot name="header">
        <h2>🎮 Minijuego: {{ $lesson->titulo }}</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 4px;">{{ $course->titulo }}</p>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 800px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('alumno.courses.lesson', [$course, $lesson]) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a la lección</a>
            </div>

            @if($score && $score->completado)
                <div style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border-radius: 16px; padding: 20px; margin-bottom: 24px; text-align: center;">
                    <p style="font-size: 2rem;">🏆</p>
                    <p style="font-weight: 800; font-size: 1.2rem;">¡Ya completaste este minijuego!</p>
                    <p>Puntaje: {{ $score->score }} / {{ $score->max_score }}</p>
                </div>
            @endif

            <!-- Juego -->
            <div id="game-container" style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 32px; text-align: center;">

                <!-- Pantalla de inicio -->
                <div id="screen-start">
                    <p style="font-size: 4rem; margin-bottom: 16px;">🎈</p>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 8px;">¡Explotá los globos correctos!</h3>
                    <p style="color: #6b7280; margin-bottom: 24px;">Leé la pregunta y hacé clic en el globo con la respuesta correcta. ¡Rápido, los globos suben!</p>
                    <button onclick="startGame()" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 14px 40px; border-radius: 12px; font-weight: 800; font-size: 1.1rem; border: none; cursor: pointer;">
                        🚀 ¡Jugar!
                    </button>
                </div>

                <!-- Pantalla de juego -->
                <div id="screen-game" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="background: #dbeafe; color: #1d4ed8; padding: 6px 16px; border-radius: 20px; font-weight: 700;">
                            Pregunta <span id="current-q">1</span> / <span id="total-q">5</span>
                        </div>
                        <div style="background: #dcfce7; color: #15803d; padding: 6px 16px; border-radius: 20px; font-weight: 700;">
                            ⭐ <span id="score-display">0</span> pts
                        </div>
                        <div style="background: #fef9c3; color: #a16207; padding: 6px 16px; border-radius: 20px; font-weight: 700;">
                            ⏱️ <span id="timer">10</span>s
                        </div>
                    </div>

                    <div id="question-text" style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 32px; min-height: 60px;"></div>

                    <!-- Canvas para los globos -->
                    <canvas id="balloonCanvas" width="700" height="350" style="border-radius: 12px; background: linear-gradient(180deg, #e0f2fe 0%, #f0f9ff 100%); max-width: 100%;"></canvas>

                    <div id="feedback" style="margin-top: 16px; font-size: 1.1rem; font-weight: 700; min-height: 32px;"></div>
                </div>

                <!-- Pantalla de resultado -->
                <div id="screen-result" style="display: none;">
                    <div id="result-emoji" style="font-size: 4rem; margin-bottom: 16px;"></div>
                    <h3 id="result-title" style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 8px;"></h3>
                    <p id="result-score" style="font-size: 1.1rem; color: #6b7280; margin-bottom: 24px;"></p>
                    <div style="display: flex; gap: 12px; justify-content: center;">
                        <button onclick="restartGame()" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer;">
                            🔄 Jugar de nuevo
                        </button>
                        <a href="{{ route('alumno.courses.lesson', [$course, $lesson]) }}" style="background: #e5e7eb; color: #374151; padding: 12px 28px; border-radius: 10px; font-weight: 700; text-decoration: none;">
                            Volver
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const preguntas = @json($preguntas);
        const saveUrl = "{{ route('alumno.courses.minigame.store', [$course, $lesson]) }}";
        const csrfToken = "{{ csrf_token() }}";

        let currentQ = 0;
        let score = 0;
        let timer = 10;
        let timerInterval = null;
        let balloons = [];
        let animFrame = null;
        let answered = false;

        const canvas = document.getElementById('balloonCanvas');
        const ctx = canvas.getContext('2d');

        const COLORS = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899'];

        function startGame() {
            document.getElementById('screen-start').style.display = 'none';
            document.getElementById('screen-game').style.display = 'block';
            document.getElementById('total-q').textContent = preguntas.length;
            currentQ = 0;
            score = 0;
            loadQuestion();
        }

        function loadQuestion() {
            if (currentQ >= preguntas.length) {
                endGame();
                return;
            }

            answered = false;
            const q = preguntas[currentQ];
            document.getElementById('question-text').textContent = q.pregunta;
            document.getElementById('current-q').textContent = currentQ + 1;
            document.getElementById('score-display').textContent = score;
            document.getElementById('feedback').textContent = '';

            // Crear globos
            balloons = q.opciones.map((opcion, i) => ({
                x: 80 + (i * (canvas.width - 80) / q.opciones.length),
                y: canvas.height + 60,
                radius: 45,
                color: COLORS[i % COLORS.length],
                text: opcion,
                speed: 0.8 + Math.random() * 0.5,
                isCorrect: opcion === q.correcta,
                popped: false,
            }));

            // Timer
            timer = 15;
            document.getElementById('timer').textContent = timer;
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                timer--;
                document.getElementById('timer').textContent = timer;
                if (timer <= 0) {
                    clearInterval(timerInterval);
                    if (!answered) {
                        showFeedback(false)
                        setTimeout(() => nextQuestion(), 1500);
                    }
                }
            }, 1000);

            // Animar
            cancelAnimationFrame(animFrame);
            animate();
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            balloons.forEach(b => {
                if (b.popped) return;
                b.y -= b.speed;

                // Globo
                ctx.beginPath();
                ctx.arc(b.x, b.y, b.radius, 0, Math.PI * 2);
                ctx.fillStyle = b.color;
                ctx.fill();
                ctx.strokeStyle = 'rgba(0,0,0,0.1)';
                ctx.lineWidth = 2;
                ctx.stroke();

                // Brillo
                ctx.beginPath();
                ctx.arc(b.x - 12, b.y - 12, 10, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,0.4)';
                ctx.fill();

                // Hilo
                ctx.beginPath();
                ctx.moveTo(b.x, b.y + b.radius);
                ctx.lineTo(b.x, b.y + b.radius + 20);
                ctx.strokeStyle = '#94a3b8';
                ctx.lineWidth = 1.5;
                ctx.stroke();

                // Texto
                ctx.fillStyle = 'white';
                ctx.font = 'bold 13px Nunito, sans-serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                // Texto multilínea
                const words = b.text.split(' ');
                let lines = [];
                let line = '';
                words.forEach(word => {
                    if ((line + word).length > 10) {
                        lines.push(line.trim());
                        line = word + ' ';
                    } else {
                        line += word + ' ';
                    }
                });
                lines.push(line.trim());
                lines = lines.filter(l => l);

                lines.forEach((l, i) => {
                    ctx.fillText(l, b.x, b.y - ((lines.length - 1) * 8) + i * 16);
                });
            });

            animFrame = requestAnimationFrame(animate);
        }

        canvas.addEventListener('click', (e) => {
            if (answered) return;
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;
            const mx = (e.clientX - rect.left) * scaleX;
            const my = (e.clientY - rect.top) * scaleY;

            balloons.forEach(b => {
                if (b.popped) return;
                const dist = Math.sqrt((mx - b.x) ** 2 + (my - b.y) ** 2);
                if (dist <= b.radius) {
                    b.popped = true;
                    answered = true;
                    clearInterval(timerInterval);

                    if (b.isCorrect) {
                        score++;
                        showFeedback(true);
                    } else {
                        showFeedback(false);
                    }

                    setTimeout(() => {
                        currentQ++;
                        nextQuestion();
                    }, 1500);
                }
            });
        });

        // Touch support
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            canvas.dispatchEvent(new MouseEvent('click', {
                clientX: touch.clientX,
                clientY: touch.clientY
            }));
        });

        function showFeedback(correct) {
            const el = document.getElementById('feedback');
            if (correct) {
                el.textContent = '✅ ¡Correcto! +1 punto';
                el.style.color = '#16a34a';
            } else {
                const correcta = preguntas[currentQ]?.correcta;
                el.textContent = `❌ Incorrecto. La respuesta era: ${correcta}`;
                el.style.color = '#dc2626';
            }
        }

        function nextQuestion() {
            cancelAnimationFrame(animFrame);
            loadQuestion();
        }

        function endGame() {
            cancelAnimationFrame(animFrame);
            clearInterval(timerInterval);

            document.getElementById('screen-game').style.display = 'none';
            document.getElementById('screen-result').style.display = 'block';

            const total = preguntas.length;
            const pct = Math.round((score / total) * 100);

            document.getElementById('result-emoji').textContent = pct >= 70 ? '🏆' : pct >= 40 ? '😊' : '💪';
            document.getElementById('result-title').textContent = pct >= 70 ? '¡Excelente!' : pct >= 40 ? '¡Buen intento!' : '¡Seguí practicando!';
            document.getElementById('result-score').textContent = `Acertaste ${score} de ${total} preguntas (${pct}%)`;

            // Guardar puntaje
            fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ score, max_score: total }),
            });
        }

        function restartGame() {
            document.getElementById('screen-result').style.display = 'none';
            document.getElementById('screen-game').style.display = 'block';
            currentQ = 0;
            score = 0;
            loadQuestion();
        }
    </script>
</x-app-layout>