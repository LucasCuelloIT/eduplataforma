import * as fabric from 'fabric'

window.addEventListener('load', () => {
    const canvasEl = document.getElementById('pizarra-canvas')
    if (!canvasEl) return

    const container = canvasEl.parentElement
    const width = container.offsetWidth || 700
    const height = 450

    canvasEl.width = width
    canvasEl.height = height

    const canvas = new fabric.Canvas('pizarra-canvas', {
        isDrawingMode: true,
        width: width,
        height: height,
        backgroundColor: '#ffffff',
    })

    canvas.freeDrawingBrush = new fabric.PencilBrush(canvas)
    canvas.freeDrawingBrush.color = '#1e293b'
    canvas.freeDrawingBrush.width = 3

    document.getElementById('pizarra-color')?.addEventListener('input', e => {
        canvas.freeDrawingBrush.color = e.target.value
    })

    document.getElementById('pizarra-size')?.addEventListener('input', e => {
        canvas.freeDrawingBrush.width = parseInt(e.target.value)
    })

    document.getElementById('pizarra-draw')?.addEventListener('click', () => {
        canvas.isDrawingMode = true
    })

    document.getElementById('pizarra-select')?.addEventListener('click', () => {
        canvas.isDrawingMode = false
    })

    document.getElementById('pizarra-clear')?.addEventListener('click', () => {
        if (confirm('¿Limpiar la pizarra?')) {
            canvas.clear()
            canvas.backgroundColor = '#ffffff'
            canvas.renderAll()
        }
    })

    document.getElementById('pizarra-text')?.addEventListener('click', () => {
        canvas.isDrawingMode = false
        const text = new fabric.IText('Escribí acá', {
            left: 100,
            top: 100,
            fontSize: 20,
            fill: canvas.freeDrawingBrush.color,
            fontFamily: 'Nunito, sans-serif',
        })
        canvas.add(text)
        canvas.setActiveObject(text)
        canvas.renderAll()
    })

    document.getElementById('pizarra-delete')?.addEventListener('click', () => {
        const active = canvas.getActiveObjects()
        active.forEach(obj => canvas.remove(obj))
        canvas.discardActiveObject()
        canvas.renderAll()
    })

    document.getElementById('pizarra-save')?.addEventListener('click', () => {
        const dataUrl = canvas.toDataURL({ format: 'png', quality: 0.8 })
        const input = document.getElementById('pizarra-data')
        if (input) input.value = dataUrl
        const saved = document.getElementById('pizarra-saved')
        if (saved) {
            saved.style.display = 'inline'
            setTimeout(() => saved.style.display = 'none', 2000)
        }
    })

    // Cargar pizarra existente
    const existing = document.getElementById('pizarra-data')?.value
    if (existing && existing.startsWith('data:image')) {
        fabric.FabricImage.fromURL(existing).then(img => {
            img.scaleToWidth(canvas.width)
            canvas.add(img)
            canvas.renderAll()
        })
    }

    window.pizarraCanvas = canvas
})