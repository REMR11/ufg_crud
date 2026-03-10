/**
 * Validación de Formularios y Autocomplete para CRUD
 * Este archivo contiene funciones para validación de formularios en cliente
 * y autocomplete para seleccionar carreras
 */

document.addEventListener('DOMContentLoaded', function() {
    // Validación Bootstrap en formularios
    setupBootstrapValidation();
    
    // Autocomplete para campos de carrera (si existen)
    setupCarreraAutocomplete();
});

/**
 * Configurar validación Bootstrap 5
 * Valida los formularios antes de enviarlos
 */
function setupBootstrapValidation() {
    // Obtener todos los formularios que requieren validación
    const forms = document.querySelectorAll('form[id^="form"]');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            // Si el formulario no es válido
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        });
    });
}

/**
 * Configurar autocomplete para carreras
 * Búsqueda dinámica de carreras al escribir
 */
function setupCarreraAutocomplete() {
    const carreraSelects = document.querySelectorAll('#codigo_carrera');
    
    carreraSelects.forEach(select => {
        if (select) {
            // Las opciones ya vienen del servidor en el select
            // No necesitamos autocomplete avanzado en este caso
            // Pero agregamos una búsqueda rápida en el select
            select.addEventListener('change', function() {
                // Agregar validación visual
                if (this.value === '') {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
            
            select.addEventListener('input', function() {
                // Búsqueda de opciones mientras se escribe
                const searchTerm = this.value.toLowerCase();
                const options = this.querySelectorAll('option');
                
                let found = false;
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    if (text.includes(searchTerm) || option.value === searchTerm) {
                        found = true;
                    }
                });
            });
        }
    });
}

/**
 * Validar email en tiempo real
 */
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Validar teléfono (8 dígitos)
 */
function validatePhone(phone) {
    const phoneRegex = /^\d{8}$/;
    return phoneRegex.test(phone.replace(/\D/g, ''));
}

/**
 * Validar código de estudiante (alfanumérico)
 */
function validateStudentCode(code) {
    const codeRegex = /^[a-zA-Z0-9]{1,20}$/;
    return codeRegex.test(code);
}

/**
 * Mostrar alerta de confirmación antes de eliminar
 */
function confirmDelete(event, message = '¿Estás seguro de que deseas eliminar este registro?') {
    if (!confirm(message)) {
        event.preventDefault();
        return false;
    }
    return true;
}

/**
 * Agregar validación en tiempo real a inputs
 */
function setupRealtimeValidation() {
    // Validar nombre
    const nombreInput = document.getElementById('nombre');
    if (nombreInput) {
        nombreInput.addEventListener('blur', function() {
            if (this.value.trim().length < 2) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Validar apellido
    const apellidoInput = document.getElementById('apellido');
    if (apellidoInput) {
        apellidoInput.addEventListener('blur', function() {
            if (this.value.trim().length < 2) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Validar email
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            if (!validateEmail(this.value)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Validar teléfono (opcional)
    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('blur', function() {
            if (this.value && !validatePhone(this.value)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Validar código
    const codigoInput = document.getElementById('codigo');
    if (codigoInput) {
        codigoInput.addEventListener('blur', function() {
            if (!validateStudentCode(this.value)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
}

// Ejecutar validación en tiempo real cuando el documento está listo
document.addEventListener('DOMContentLoaded', setupRealtimeValidation);
