 $(document).ready(function() {
            $('#estadoSelect').on('change', function() {
                var estadoId = $(this).val();
                $('#municipioSelect').html('<option value="">Cargando...</option>');
                $('#parroquiaSelect').html('<option value="">Seleccione</option>');

                if (estadoId) {
                    $.ajax({
                        url: '{{ url('get-municipios') }}/' + estadoId,

                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Seleccione</option>';
                            data.forEach(function(municipio) {
                                options +=
                                    `<option value="${municipio.id}">${municipio.nombre}</option>`;
                            });
                            $('#municipioSelect').html(options);
                        },
                        error: function() {
                            alert('Error al cargar municipios.');
                            $('#municipioSelect').html('<option value="">Seleccione</option>');
                        }
                    });
                } else {
                    $('#municipioSelect').html('<option value="">Seleccione</option>');
                }
            });

            $('#municipioSelect').on('change', function() {
                var municipioId = $(this).val();
                $('#parroquiaSelect').html('<option value="">Cargando...</option>');

                if (municipioId) {
                    $.ajax({
                        url: '{{ url('get-parroquias') }}/' + municipioId,

                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Seleccione</option>';
                            data.forEach(function(parroquia) {
                                options +=
                                    `<option value="${parroquia.id}">${parroquia.nombre}</option>`;
                            });
                            $('#parroquiaSelect').html(options);
                        },
                        error: function() {
                            alert('Error al cargar parroquias.');
                            $('#parroquiaSelect').html('<option value="">Seleccione</option>');
                        }
                    });
                } else {
                    $('#parroquiaSelect').html('<option value="">Seleccione</option>');
                }
            });
        });


        Dropzone.autoDiscover = false;

        // Dropzone para imágenes
        const imagenesDropzone = new Dropzone("#myAwesomeDropzone", {
            url: "/ruta-de-envio-temporal-o-ficticia", // será ignorado si usas formData
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10,
            maxFilesize: 5, // MB
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            previewsContainer: "#file-previews",
            previewTemplate: document.querySelector("#uploadPreviewTemplate").innerHTML
        });

        Dropzone.autoDiscover = false;

        const documentosDropzone = new Dropzone("#docuemntosDropzone", {
            url: "/fake-url", // será reemplazado al enviar el formulario
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10,
            maxFilesize: 10,
            acceptedFiles: '.pdf,.doc,.docx,.xls,.xlsx,.txt',
            addRemoveLinks: true,
            previewsContainer: "#file-previews2",
            previewTemplate: document.querySelector("#uploadPreviewTemplate2").innerHTML,
            init: function() {
                this.on("addedfile", function(file) {
                    const ext = file.name.split('.').pop().toLowerCase();
                    let iconPath = "/assets/icons/file.png"; // por defecto

                    if (['doc', 'docx'].includes(ext)) {
                        iconPath = "/assets/icons/word.png";
                    } else if (['pdf'].includes(ext)) {
                        iconPath = "/assets/icons/pdf.png";
                    } else if (['xls', 'xlsx'].includes(ext)) {
                        iconPath = "/assets/icons/excel.png";
                    }

                    // Cambiar la miniatura manualmente
                    const thumbnail = file.previewElement.querySelector("[data-dz-thumbnail]");
                    thumbnail.src = iconPath;
                });
            }
        });

        // Enviar todos los archivos al enviar el formulario
        document.querySelector("form#formCaso").addEventListener("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            // Agregar imágenes
            imagenesDropzone.files.forEach((file, i) => {
                formData.append('imagenes[]', file);
            });

            // Agregar documentos
            documentosDropzone.files.forEach((file, i) => {
                formData.append('documentos[]', file);
            });

            // Enviar formulario completo por AJAX
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                if (response.ok) {
                    alert("Formulario enviado con éxito.");
                    // Opcional: reiniciar dropzones
                    imagenesDropzone.removeAllFiles();
                    documentosDropzone.removeAllFiles();
                    this.reset();
                } else {
                    alert("Error al enviar formulario.");
                }
            }).catch(error => {
                console.error(error);
                alert("Error inesperado.");
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const noAplica = document.getElementById('indicador3'); // "No aplica Indicadores"
            const checkboxes = document.querySelectorAll('input[name="indicadores[]"]:not(#indicador3)');

            // Al seleccionar "No aplica", desmarcar los demás
            noAplica.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(cb => cb.checked = false);
                }
            });

            // Al seleccionar otro, desmarcar "No aplica"
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        noAplica.checked = false;
                    }
                });
            });
        });



        
       
        $(document).ready(function() {
            const checkboxOtras = $('#otras_organizaciones'); // Este es el checkbox
            const inputContainer = $('#otrasOrganizacionesContainer');
            const inputText = inputContainer.find('input');

            checkboxOtras.on('change', function() {
                if ($(this).is(':checked')) {
                    inputContainer.show();
                    inputText.prop('disabled', false).prop('required', true);
                } else {
                    inputContainer.hide();
                    inputText.prop('disabled', true).prop('required', false).val('');
                }
            });

            // Mostrar el input si estaba seleccionado en reenvío con errores
            if (checkboxOtras.is(':checked')) {
                inputContainer.show();
                inputText.prop('disabled', false).prop('required', true);
            }
        });
    

    
        document.addEventListener('DOMContentLoaded', function() {
            const estadoSelect = document.getElementById('estadoSelect');
            const numeroCasoInput = document.querySelector('input[name="numero_caso"]');

            estadoSelect.addEventListener('change', function() {
                const estadoId = this.value;

                fetch(`/casos/contador-estado/${estadoId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.estado_nombre === 'Táchira') {
                            const nuevoNumero = String(data.conteo + 1).padStart(3, '0');
                            numeroCasoInput.value = `TCT-25-${nuevoNumero}`;
                        } else {
                            numeroCasoInput.value = '';
                        }
                    });
            });
        });
    

    
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('input[name="beneficiario[]"]');
            const estadoMujerBlock = document.getElementById('estado-mujer-block');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const valor = this.value.toLowerCase();
                    if (valor.includes('mujer') || valor.includes('niña')) {
                        estadoMujerBlock.style.display = 'block';
                    } else {
                        estadoMujerBlock.style.display = 'none';
                        // Limpia los checkboxes marcados si se oculta
                        estadoMujerBlock.querySelectorAll('input[type="checkbox"]').forEach(cb => cb
                            .checked = false);
                    }
                });
            });
        });
    

    
        document.addEventListener('DOMContentLoaded', function() {
            const embarazada = document.getElementById('embarazada');
            const lactante = document.getElementById('lactante');
            const noAplica = document.getElementById('no_aplica');

            function actualizarChecks() {
                if (noAplica.checked) {
                    embarazada.checked = false;
                    lactante.checked = false;
                }
            }

            function bloquearNoAplica() {
                if (embarazada.checked || lactante.checked) {
                    noAplica.checked = false;
                }
            }

            embarazada.addEventListener('change', function() {
                bloquearNoAplica();
            });

            lactante.addEventListener('change', function() {
                bloquearNoAplica();
            });

            noAplica.addEventListener('change', function() {
                actualizarChecks();
            });
        });
    


    
        document.addEventListener('DOMContentLoaded', function() {
            const reunificacion = document.getElementById('reunificacion_familiar');
            const localizacion = document.getElementById('localizacion_familiar');
            const retorno = document.getElementById('retorno_voluntario');

            function limpiarOtrosSiRetorno() {
                if (retorno.checked) {
                    reunificacion.checked = false;
                    localizacion.checked = false;
                }
            }

            function limpiarRetornoSiOtros() {
                if (reunificacion.checked || localizacion.checked) {
                    retorno.checked = false;
                }
            }

            reunificacion.addEventListener('change', limpiarRetornoSiOtros);
            localizacion.addEventListener('change', limpiarRetornoSiOtros);
            retorno.addEventListener('change', limpiarOtrosSiRetorno);
        });
    


    
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.acompanante-opcion');

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const esNoAplica = this.dataset.esNoAplica === '1';

                    if (esNoAplica && this.checked) {
                        // Desmarcar todos los demás si se marcó "No aplica"
                        checkboxes.forEach(other => {
                            if (other !== this) other.checked = false;
                        });
                    } else if (!esNoAplica && this.checked) {
                        // Desmarcar "No aplica" si se marcó cualquier otro
                        checkboxes.forEach(other => {
                            if (other.dataset.esNoAplica === '1') {
                                other.checked = false;
                            }
                        });
                    }
                });
            });
        });
    
    
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('representante_legal');
            const generoDiv = document.getElementById('genero_representante');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    generoDiv.style.display = 'flex'; // o 'block' si prefieres
                } else {
                    generoDiv.style.display = 'none';
                    generoDiv.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('no_aplica_acompanante');
            const generoDiv = document.getElementById('genero_representante');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    generoDiv.style.display = 'none'; // o 'block' si prefieres
                }
            });
        });
    

    
        document.addEventListener('DOMContentLoaded', function() {
            const selectPais = document.getElementById('pais_procedencia');
            const otroPaisContainer = document.getElementById('otro_pais_container');
            const otroPaisInput = document.getElementById('otro_pais');

            selectPais.addEventListener('change', function() {
                if (this.value === 'Otro País') {
                    otroPaisContainer.style.display = 'block';
                    otroPaisInput.disabled = false;
                    otroPaisInput.required = true;
                } else {
                    otroPaisContainer.style.display = 'none';
                    otroPaisInput.disabled = true;
                    otroPaisInput.required = false;
                    otroPaisInput.value = '';
                }
            });

            // Ejecutar al cargar por si viene con datos preseleccionados
            if (selectPais.value === 'Otro País') {
                otroPaisContainer.style.display = 'block';
                otroPaisInput.disabled = false;
                otroPaisInput.required = true;
            }
        });
    


    
        document.addEventListener('DOMContentLoaded', function() {
            const selectEtnia = document.getElementById('etnia_indigena');
            const otraEtniaContainer = document.getElementById('otra_etnia_container');
            const otraEtniaInput = document.getElementById('otra_etnia');

            selectEtnia.addEventListener('change', function() {
                if (this.value === 'Otra Etnia') {
                    otraEtniaContainer.style.display = 'block';
                    otraEtniaInput.disabled = false;
                    otraEtniaInput.required = true;
                } else {
                    otraEtniaContainer.style.display = 'none';
                    otraEtniaInput.disabled = true;
                    otraEtniaInput.required = false;
                    otraEtniaInput.value = '';
                }
            });

            // Ejecutar al cargar por si ya está seleccionado
            if (selectEtnia.value === 'Otra Etnia') {
                otraEtniaContainer.style.display = 'block';
                otraEtniaInput.disabled = false;
                otraEtniaInput.required = true;
            }
        });
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const ninguno = document.getElementById("ningun_servicio_cosude");
            const checkboxes = document.querySelectorAll(
                'input[name="servicio_cosude[]"]:not(#ningun_servicio_cosude)');

            if (ninguno) {
                ninguno.addEventListener("change", function() {
                    if (this.checked) {
                        checkboxes.forEach(cb => cb.checked = false);
                    }
                });

                checkboxes.forEach(cb => {
                    cb.addEventListener("change", function() {
                        if (this.checked) {
                            ninguno.checked = false;
                        }
                    });
                });
            }
        });
    


    
        document.addEventListener("DOMContentLoaded", function() {
            const ningunoUnicef = document.getElementById("ningun_servicio_unicef");
            const otrosUnicef = document.querySelectorAll(
                'input[name="servicio_unicef[]"]:not(#ningun_servicio_unicef)');

            if (ningunoUnicef) {
                ningunoUnicef.addEventListener("change", function() {
                    if (this.checked) {
                        otrosUnicef.forEach(cb => cb.checked = false);
                    }
                });

                otrosUnicef.forEach(cb => {
                    cb.addEventListener("change", function() {
                        if (this.checked) {
                            ningunoUnicef.checked = false;
                        }
                    });
                });
            }
        });
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const unicefCheckbox = document.getElementById("unicef");
            const cosudeCheckbox = document.getElementById("cosude");

            const unicefContainer = document.getElementById("servicios_brindados_unicef_block");
            const cosudeContainer = document.getElementById("servicios_brindados_cosude_container");

            function actualizarVisibilidad() {
                // Verificar si están marcados exactamente
                const unicefMarcado = unicefCheckbox.checked;
                const cosudeMarcado = cosudeCheckbox.checked;

                // Mostrar u ocultar contenedores
                unicefContainer.style.display = unicefMarcado ? 'block' : 'none';
                cosudeContainer.style.display = cosudeMarcado ? 'block' : 'none';
            }

            // Ejecutar al cargar
            actualizarVisibilidad();

            // Añadir eventos a ambos checkboxes
            unicefCheckbox.addEventListener("change", actualizarVisibilidad);
            cosudeCheckbox.addEventListener("change", actualizarVisibilidad);
        });
    


    
        document.addEventListener("DOMContentLoaded", function() {
            // COSUDE
            const ningunoCosude = document.querySelector(
                'input[name="servicio_brindado_cosude[]"][value="Ningún servicio COSUDE"]');
            const otrosCosude = document.querySelectorAll(
                'input[name="servicio_brindado_cosude[]"]:not([value="Ningún servicio COSUDE"])');

            ningunoCosude.addEventListener('change', function() {
                if (this.checked) {
                    otrosCosude.forEach(cb => cb.checked = false);
                }
            });

            otrosCosude.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        ningunoCosude.checked = false;
                    }
                });
            });

            // UNICEF
            const ningunoUnicef = document.querySelector(
                'input[name="servicio_brindado_unicef[]"][value="Ningún servicio UNICEF"]');
            const otrosUnicef = document.querySelectorAll(
                'input[name="servicio_brindado_unicef[]"]:not([value="Ningún servicio UNICEF"])');

            ningunoUnicef.addEventListener('change', function() {
                if (this.checked) {
                    otrosUnicef.forEach(cb => cb.checked = false);
                }
            });

            otrosUnicef.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        ningunoUnicef.checked = false;
                    }
                });
            });
        });
    
    
        document.addEventListener("DOMContentLoaded", function() {
            const radiosBeneficiario = document.querySelectorAll('input[name="beneficiario"]');
            const radiosEducacion = document.querySelectorAll('input[name="educacion"]');

            const bloqueEducacion = document.getElementById("bloque_educacion");
            const bloqueNivelTipo = document.getElementById("bloque_nivel_educativo_tipo_isntitucion");
            const bloqueEstadoMujer = document.getElementById("estado-mujer-block");

            function actualizarBloques() {
                const beneficiario = document.querySelector('input[name="beneficiario"]:checked');
                const educacion = document.querySelector('input[name="educacion"]:checked');
                const valor = beneficiario ? beneficiario.value.trim() : "";

                // Mostrar educación si es NNA
                const esNNA = valor === "Niña adolescente" || valor === "Niño adolescente";
                bloqueEducacion.style.display = esNNA ? "block" : "none";

                // Mostrar nivel educativo + tipo institución si "Si estudia"
                const estudia = educacion && educacion.value === "Si estudia";
                bloqueNivelTipo.style.display = (esNNA && estudia) ? "flex" : "none";

                // Mostrar bloque de estado si es mujer (niña adolescente, mujer joven o mujer adulta)
                const esMujer = valor === "Niña adolescente" || valor === "Mujer joven" || valor === "Mujer adulta";
                bloqueEstadoMujer.style.display = esMujer ? "block" : "none";
            }

            radiosBeneficiario.forEach(rb => rb.addEventListener("change", actualizarBloques));
            radiosEducacion.forEach(rb => rb.addEventListener("change", actualizarBloques));

            // Ejecutar al cargar por si hay datos precargados
            actualizarBloques();
        });
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const selectEdad = document.getElementById("edad-beneficiario-select");
            const radiosBeneficiario = document.querySelectorAll('input[name="beneficiario"]');

            const rangos = {
                'nina_adolescente': [0, 17],
                'mujer_joven': [18, 21],
                'mujer_adulta': [22, 100],
                'nino_adolescente': [0, 17],
                'hombre_joven': [18, 21],
                'hombre_adulto': [22, 100]
            };

            function normalizarTexto(texto) {
                return texto
                    .toLowerCase()
                    .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // quita tildes
                    .replace(/\s+/g, '_'); // espacios a guión bajo
            }

            function cargarRangoDeEdad(valorNormalizado) {
                selectEdad.innerHTML = '<option value="">Seleccione</option>';

                if (!(valorNormalizado in rangos)) return;

                const [min, max] = rangos[valorNormalizado];
                for (let i = min; i <= max; i++) {
                    const option = document.createElement("option");
                    option.value = i;
                    option.textContent = `${i} años`;
                    selectEdad.appendChild(option);
                }
            }

            radiosBeneficiario.forEach(radio => {
                radio.addEventListener("change", function() {
                    const slug = normalizarTexto(this.value);
                    cargarRangoDeEdad(slug);
                });
            });

            // Ejecutar al cargar si hay selección previa
            const seleccionado = document.querySelector('input[name="beneficiario"]:checked');
            if (seleccionado) {
                const slug = normalizarTexto(seleccionado.value);
                cargarRangoDeEdad(slug);
            }
        });
    


    
        document.addEventListener("DOMContentLoaded", function() {
            const checkNoAplica = document.querySelector('input[name="estado_mujer[]"][value="No aplica estado"]');
            const otrosEstados = document.querySelectorAll(
                'input[name="estado_mujer[]"]:not([value="No aplica estado"])');

            if (checkNoAplica) {
                checkNoAplica.addEventListener("change", function() {
                    if (this.checked) {
                        otrosEstados.forEach(cb => cb.checked = false);
                    }
                });

                otrosEstados.forEach(cb => {
                    cb.addEventListener("change", function() {
                        if (this.checked) {
                            checkNoAplica.checked = false;
                        }
                    });
                });
            }
        });
    

    
        $(document).ready(function() {
            // Estado destino → Municipio destino
            $('#estadoDestinoSelect').on('change', function() {
                var estadoId = $(this).val();
                $('#municipioDestinoSelect').html('<option value="">Cargando...</option>');
                $('#parroquiaDestinoSelect').html('<option value="">Seleccione</option>');

                if (estadoId) {
                    $.ajax({
                        url: '{{ url('get-municipios') }}/' + estadoId,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Seleccione</option>';
                            data.forEach(function(municipio) {
                                options +=
                                    `<option value="${municipio.id}">${municipio.nombre}</option>`;
                            });
                            $('#municipioDestinoSelect').html(options);
                        },
                        error: function() {
                            alert('Error al cargar municipios destino.');
                            $('#municipioDestinoSelect').html(
                                '<option value="">Seleccione</option>');
                        }
                    });
                } else {
                    $('#municipioDestinoSelect').html('<option value="">Seleccione</option>');
                }
            });

            // Municipio destino → Parroquia destino
            $('#municipioDestinoSelect').on('change', function() {
                var municipioId = $(this).val();
                $('#parroquiaDestinoSelect').html('<option value="">Cargando...</option>');

                if (municipioId) {
                    $.ajax({
                        url: '{{ url('get-parroquias') }}/' + municipioId,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Seleccione</option>';
                            data.forEach(function(parroquia) {
                                options +=
                                    `<option value="${parroquia.id}">${parroquia.nombre}</option>`;
                            });
                            $('#parroquiaDestinoSelect').html(options);
                        },
                        error: function() {
                            alert('Error al cargar parroquias destino.');
                            $('#parroquiaDestinoSelect').html(
                                '<option value="">Seleccione</option>');
                        }
                    });
                } else {
                    $('#parroquiaDestinoSelect').html('<option value="">Seleccione</option>');
                }
            });
        });
    


    
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxOtros = document.getElementById("otros_tipos_de_actuacion");
            const containerTexto = document.getElementById("otros_actuacion_container");

            if (checkboxOtros) {
                checkboxOtros.addEventListener("change", function() {
                    containerTexto.style.display = this.checked ? 'block' : 'none';
                });

                // Mostrar si ya estaba seleccionado al recargar
                if (checkboxOtros.checked) {
                    containerTexto.style.display = 'block';
                }
            }
        });
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const checkNoIdentifica = document.querySelector(
                'input[name="vulnerabilidades[]"][value="No se identifica vulnerabilidad"]');
            const otrasVulnerabilidades = document.querySelectorAll(
                'input[name="vulnerabilidades[]"]:not([value="No se identifica vulnerabilidad"])');

            if (checkNoIdentifica) {
                checkNoIdentifica.addEventListener("change", function() {
                    if (this.checked) {
                        otrasVulnerabilidades.forEach(cb => cb.checked = false);
                    }
                });

                otrasVulnerabilidades.forEach(cb => {
                    cb.addEventListener("change", function() {
                        if (this.checked) {
                            checkNoIdentifica.checked = false;
                        }
                    });
                });
            }
        });
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const checkNoAplica = document.querySelector(
                'input[name="derechos_vulnerados[]"][value="NO Aplica Derechos Vulnerados"]');
            const otrosDerechos = document.querySelectorAll(
                'input[name="derechos_vulnerados[]"]:not([value="NO Aplica Derechos Vulnerados"])');

            if (checkNoAplica) {
                checkNoAplica.addEventListener("change", function() {
                    if (this.checked) {
                        otrosDerechos.forEach(cb => cb.checked = false);
                    }
                });

                otrosDerechos.forEach(cb => {
                    cb.addEventListener("change", function() {
                        if (this.checked) {
                            checkNoAplica.checked = false;
                        }
                    });
                });
            }
        });
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const checkNoVBG = document.querySelector(
                'input[name="identificacion_violencia[]"][value="No se identifica VBG"]');
            const otrasViolencias = document.querySelectorAll(
                'input[name="identificacion_violencia[]"]:not([value="No se identifica VBG"])');

            if (checkNoVBG) {
                checkNoVBG.addEventListener("change", function() {
                    if (this.checked) {
                        otrasViolencias.forEach(cb => cb.checked = false);
                    }
                });

                otrasViolencias.forEach(cb => {
                    cb.addEventListener("change", function() {
                        if (this.checked) {
                            checkNoVBG.checked = false;
                        }
                    });
                });
            }
        });
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxesVBG = document.querySelectorAll('input[name="identificacion_violencia[]"]');
            const violenciaVicaria = document.querySelector(
                'input[name="identificacion_violencia[]"][value="Violencia Vicaría"]');
            const noIdentifica = document.querySelector(
                'input[name="identificacion_violencia[]"][value="No se identifica VBG"]');
            const bloqueVicaria = document.getElementById("bloque_tipos_vicaria");

            // Obtener los checkboxes del bloque vicaria
            function getVicariaCheckboxes() {
                return document.querySelectorAll('input[name="tipos_violencia_vicaria[]"]');
            }

            // Al seleccionar "No se identifica VBG"
            noIdentifica?.addEventListener("change", function() {
                if (this.checked) {
                    // Desmarcar todos los demás checkboxes de violencia
                    checkboxesVBG.forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });

                    // Desmarcar todos los tipos de violencia vicaria
                    getVicariaCheckboxes().forEach(cb => cb.checked = false);

                    // Ocultar bloque de violencia vicaria
                    bloqueVicaria.style.display = "none";
                }
            });

            // Al seleccionar "Violencia Vicaría"
            violenciaVicaria?.addEventListener("change", function() {
                if (this.checked) {
                    // Mostrar bloque de violencia vicaria
                    bloqueVicaria.style.display = "block";

                    // Desmarcar "No se identifica VBG"
                    if (noIdentifica.checked) noIdentifica.checked = false;
                } else {
                    // Si se desmarca violencia vicaria, ocultar bloque y desmarcar opciones internas
                    bloqueVicaria.style.display = "none";
                    getVicariaCheckboxes().forEach(cb => cb.checked = false);
                }
            });

            // Desmarcar "No se identifica VBG" si se marca cualquier otro tipo de violencia
            checkboxesVBG.forEach(cb => {
                if (cb !== noIdentifica && cb !== violenciaVicaria) {
                    cb.addEventListener("change", function() {
                        if (this.checked && noIdentifica.checked) {
                            noIdentifica.checked = false;
                        }
                    });
                }
            });
        });
    

    
        $(document).ready(function() {
            $('#sin_remision').on('change', function() {
                if ($(this).is(':checked')) {
                    // Desmarcar todos los demás checkbox excepto "Sin Remisión"
                    $('input[name="remisiones[]"]').not(this).prop('checked', false);
                }
            });

            // Si se marca otro checkbox, desmarcar "Sin Remisión"
            $('input[name="remisiones[]"]').not('#sin_remision').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#sin_remision').prop('checked', false);
                }
            });
        });
    

    
        $(document).ready(function() {
            $('#pais_nacimiento').on('change', function() {
                const seleccion = $(this).val();
                const bloque = $('#otro_pais_nacimiento_container');
                const input = $('#otro_pais_nacimientos');

                if (seleccion === 'Otro País') {
                    bloque.slideDown();
                    input.prop('required', true);
                } else {
                    bloque.slideUp();
                    input.val('').prop('required', false);
                }
            });
        });
    

