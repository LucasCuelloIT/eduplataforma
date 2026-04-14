import * as fabric from 'fabric'

document.addEventListener('DOMContentLoaded', () => {
    const canvasEl = document.getElementById('pizarra-canvas')
    if (!canvasEl) return

    const canvas = new fabric.Canvas('pizarra-canvas', {
        isDrawingMode: true,
        width: canvasEl.parentElement.offsetWidth - 32,
        height: 450,
        backgroundColor: '#ffffff',
    })

    // Brush por defecto
    canvas.freeDrawingBrush.color = '#1e293b'
    canvas.freeDrawingBrush.width = 3

    // Toolbar
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
    })

    document.getElementById('pizarra-delete')?.addEventListener('click', () => {
        const active = canvas.getActiveObjects()
        active.forEach(obj => canvas.remove(obj))
        canvas.discardActiveObject()
        canvas.renderAll()
    })

    // Guardar pizarra
    document.getElementById('pizarra-save')?.addEventListener('click', () => {
        const dataUrl = canvas.toDataURL({ format: 'png', quality: 0.8 })
        const input = document.getElementById('pizarra-data')
        if (input) input.value = dataUrl
        document.getElementById('pizarra-saved')?.style && (document.getElementById('pizarra-saved').style.display = 'block')
        setTimeout(() => {
            const el = document.getElementById('pizarra-saved')
            if (el) el.style.display = 'none'
        }, 2000)
    })

    // Cargar pizarra existente
    const existing = document.getElementById('pizarra-data')?.value
    if (existing && existing.startsWith('data:image')) {
        fabric.Image.fromURL(existing, img => {
            img.scaleToWidth(canvas.width)
            canvas.add(img)
            canvas.renderAll()
        })
    }

    window.pizarraCanvas = canvas
})