class AudioEngine {

    constructor() {

        this.audioContext = null

        this.leftOscillator = null
        this.rightOscillator = null

        this.leftGain = null
        this.rightGain = null

        this.masterGain = null

        this.ambientAudio = null

        this.isRunning = false

    }

    init() {

        if (!this.audioContext) {

            this.audioContext = new (window.AudioContext || window.webkitAudioContext)()

            this.masterGain = this.audioContext.createGain()
            this.masterGain.gain.value = 0.5
            this.masterGain.connect(this.audioContext.destination)

        }

    }

    startBrainwave(baseFrequency, beatFrequency) {

        this.init()

        const leftFreq = baseFrequency
        const rightFreq = baseFrequency + beatFrequency

        this.leftOscillator = this.audioContext.createOscillator()
        this.rightOscillator = this.audioContext.createOscillator()

        this.leftGain = this.audioContext.createGain()
        this.rightGain = this.audioContext.createGain()

        this.leftOscillator.frequency.value = leftFreq
        this.rightOscillator.frequency.value = rightFreq

        this.leftGain.gain.value = 0.5
        this.rightGain.gain.value = 0.5

        const leftPanner = this.audioContext.createStereoPanner()
        const rightPanner = this.audioContext.createStereoPanner()

        leftPanner.pan.value = -1
        rightPanner.pan.value = 1

        this.leftOscillator.connect(this.leftGain)
        this.rightOscillator.connect(this.rightGain)

        this.leftGain.connect(leftPanner)
        this.rightGain.connect(rightPanner)

        leftPanner.connect(this.masterGain)
        rightPanner.connect(this.masterGain)

        this.leftOscillator.start()
        this.rightOscillator.start()

        this.isRunning = true

    }

    stopBrainwave() {

        if (!this.isRunning) return

        this.leftOscillator.stop()
        this.rightOscillator.stop()

        this.leftOscillator.disconnect()
        this.rightOscillator.disconnect()

        this.isRunning = false

    }

    playAmbient(file) {

        this.init()

        if (this.ambientAudio) {

            this.ambientAudio.pause()
            this.ambientAudio = null

        }

        this.ambientAudio = new Audio(file)
        this.ambientAudio.loop = true
        this.ambientAudio.volume = 0.5
        this.ambientAudio.play()

    }

    stopAmbient() {

        if (!this.ambientAudio) return

        this.ambientAudio.pause()
        this.ambientAudio = null

    }

    setVolume(value) {

        if (!this.masterGain) return

        this.masterGain.gain.value = value

    }

}

window.AudioEngine = new AudioEngine()