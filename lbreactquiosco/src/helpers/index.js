

// Vacío en local usa la ruta relativa. En producción es el dominio del sitio.
export function mediaUrl(path) {
    if (!path) return ''
    if (/^https?:\/\//i.test(path)) return path
    const origin = String(import.meta.env.VITE_API_URL || '').replace(/\/$/, '')
    const clean = path.startsWith('/') ? path : `/${path}`
    return `${origin}${clean}`
}

export const formatearDinero = cantidad =>{
    return cantidad.toLocaleString('es-MX',
        {
            style:'currency',
            currency:'MXN'
        }
    )
}