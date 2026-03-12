<div class="card">

    <div class="card-header">
        <h3 class="card-title">Audio Session</h3>
    </div>

    <div class="card-body">

        <div class="mb-3">

            <label>Brainwave preset</label>

            <select id="preset" class="form-control">

                <option value="delta" data-freq="3">Deep Sleep (Delta)</option>
                <option value="theta" data-freq="6">Meditation (Theta)</option>
                <option value="alpha" data-freq="10">Relax (Alpha)</option>
                <option value="beta" data-freq="18">Focus (Beta)</option>

            </select>

        </div>

        <div class="mb-3">

            <label>Ambient Sound</label>

            <select id="ambient" class="form-control">

                <option value="">None</option>
                <option value="/audio/rain.mp3">Rain</option>
                <option value="/audio/ocean.mp3">Ocean</option>
                <option value="/audio/forest.mp3">Forest</option>
                <option value="/audio/wind.mp3">Wind</option>

            </select>

        </div>

        <div class="mb-3">

            <label>Volume</label>

            <input type="range" id="volume" min="0" max="1" step="0.01" value="0.5" class="form-control">

        </div>

        <button id="startSession" class="btn btn-success">
            Start Session
        </button>

        <button id="stopSession" class="btn btn-danger">
            Stop
        </button>

    </div>

</div>

<script src="/js/audio-engine.js"></script>

<script>

document.getElementById('startSession').addEventListener('click', function () {

    const preset = document.getElementById('preset')

    const beatFreq = parseFloat(preset.selectedOptions[0].dataset.freq)

    AudioEngine.startBrainwave(200, beatFreq)

    const ambient = document.getElementById('ambient').value

    if (ambient !== '') {

        AudioEngine.playAmbient(ambient)

    }

})

document.getElementById('stopSession').addEventListener('click', function () {

    AudioEngine.stopBrainwave()
    AudioEngine.stopAmbient()

})

document.getElementById('volume').addEventListener('input', function () {

    AudioEngine.setVolume(this.value)

})

</script>