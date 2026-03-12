let audioContext;
let oscillatorLeft;
let oscillatorRight;
let gainNode;

let ambientAudio = null;
let brainwaveAudio = null;

function startGenerator(frequency)
{
    audioContext = new (window.AudioContext || window.webkitAudioContext)();

    let baseFreq = 200;

    oscillatorLeft = audioContext.createOscillator();
    oscillatorRight = audioContext.createOscillator();

    let gainLeft = audioContext.createGain();
    let gainRight = audioContext.createGain();

    let merger = audioContext.createChannelMerger(2);

    oscillatorLeft.frequency.value = baseFreq;
    oscillatorRight.frequency.value = baseFreq + frequency;

    oscillatorLeft.connect(gainLeft);
    oscillatorRight.connect(gainRight);

    gainLeft.connect(merger, 0, 0);
    gainRight.connect(merger, 0, 1);

    gainNode = audioContext.createGain();
    gainNode.gain.value = 0.5;

    merger.connect(gainNode);
    gainNode.connect(audioContext.destination);

    oscillatorLeft.start();
    oscillatorRight.start();
}

function stopGenerator()
{
    if(oscillatorLeft)
    {
        oscillatorLeft.stop();
        oscillatorRight.stop();
        audioContext.close();
    }
}

function playBrainwaveAudio(file)
{
    brainwaveAudio = new Audio('/' + file);
    brainwaveAudio.loop = true;
    brainwaveAudio.volume = 0.5;
    brainwaveAudio.play();
}

function stopBrainwaveAudio()
{
    if(brainwaveAudio)
    {
        brainwaveAudio.pause();
        brainwaveAudio = null;
    }
}

function playAmbient(file)
{
    ambientAudio = new Audio('/' + file);
    ambientAudio.loop = true;
    ambientAudio.volume = 0.5;
    ambientAudio.play();
}

function stopAmbient()
{
    if(ambientAudio)
    {
        ambientAudio.pause();
        ambientAudio = null;
    }
}

function startSession()
{
    let preset = document.getElementById('preset').selectedOptions[0];

    let mode = preset.dataset.mode;
    let freq = preset.dataset.frequency;
    let audio = preset.dataset.audio;

    let ambient = document.getElementById('ambient').value;

    if(mode === 'generator')
    {
        startGenerator(parseFloat(freq));
    }

    if(mode === 'audio')
    {
        playBrainwaveAudio(audio);
    }

    if(ambient)
    {
        playAmbient(ambient);
    }
}

function stopSession()
{
    stopGenerator();
    stopBrainwaveAudio();
    stopAmbient();
}