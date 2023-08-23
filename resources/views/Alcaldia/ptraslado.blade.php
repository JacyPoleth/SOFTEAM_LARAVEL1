@extends('adminlte::page')

@section('title', 'Alcaldia')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Clase CSS personalizada aquí -->
    <style>
        /* CSS personalizado */
        .custom-delete-button:hover .fas.fa-trash-alt {
            color: white !important;
        }
    </style>
    <style>
                /* Boton Nuevo */
                .Btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 40px;
            height: 40px;
            border-radius: calc(45px/2);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: rgb(0, 143, 0);
            }

        /* plus sign */
        .sign {
            width: 100%;
            font-size: 2.0em;
            color: white;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* text */
        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: white;
            font-size: 1.0em;
            font-weight: 300;
            transition-duration: .3s;
        }
        /* hover effect on button width */
        .Btn:hover {
            width: 125px;
            transition-duration: .3s;
        }

        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 15px;
        }
        /* hover effect button's text */
        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 15px;
        }
        /* button click effect*/
        .Btn:active {
            transform: translate(2px ,2px);
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
   
@stop

@section('content_header')
@if(session()->has('user_data'))
        <?php
            $authController = app(\App\Http\Controllers\AuthController::class);
            $objeto = 'Permisos de Traslado'; // Por ejemplo, el objeto deseado
            $rol = session('user_data')['NOM_ROL'];
            $tienePermiso = $authController->tienePermiso($rol, $objeto);
        ?>
    @if(session()->has('PRM_CONSULTAR') && session('PRM_CONSULTAR') == "S")
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <center><br>
        <h1>Información de Permisos de Traslado</h1>
    </center></br>

@section('content')
    <!-- Boton Nuevo -->
    @if(session()->has('PRM_INSERTAR') && session('PRM_INSERTAR') == "S")
    <p align="right">
                <button type="button" class="Btn" data-toggle="modal" data-target="#ptraslado">
                    <div class="sign">+</div>
                    <div class="text">Nuevo</div>
                </button>
            </p>
    @endif
    <div class="modal fade bd-example-modal-sm" id="ptraslado" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title">Ingresa un Nuevo Permiso de Traslado</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                   
                </div>
                <div class="modal-body">
                    <p>Ingresar Datos Solicitados:</p>
                    <form action="{{ url('ptraslado/insertar') }}" method="post" class="needs-validation">
                        @csrf                           

                            <div class="mb-3">
                                <label for="FEC_TRASLADO">Fecha del Traslado</label>
                                <input type="date" id="FEC_TRASLADO" class="form-control" name="FEC_TRASLADO" placeholder="Inserte la fecha del Traslado" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="COD_PERSONA" class="form-label">Persona: </label>
                                <select class="form-select" id="COD_PERSONA" name="COD_PERSONA" required>
                                <option value="" disabled selected>Seleccione una Persona</option>
                                @foreach ($personasArreglo as $persona)
                                    <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOM_PERSONA'] }} </option>
                                @endforeach
                            </select>
                            </div>

                            <div class="mb-3">
                                <label for="DIR_ORIG_PTRASLADO">Direccion de Origen del Traslado</label>
                                <input type="text" id="DIR_ORIG_PTRASLADO" class="form-control" name="DIR_ORIG_PTRASLADO" placeholder="Ingresar la direccion de origen del traslado" required>
                                <div class="invalid-feedback"></div>
                            </div>
                              
                            <div class="mb-3">
                                <label for="DIR_DEST_TRASLADO">Direccion de Destino del Traslado</label>
                                <input type="text" id="DIR_DEST_TRASLADO" class="form-control" name="DIR_DEST_TRASLADO" placeholder="Ingresar la direccion de destino del traslado" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="NOM_TRANSPORTISTA">Nombre del Transportista</label>
                                <input type="text" id="NOM_TRANSPORTISTA" class="form-control" name="NOM_TRANSPORTISTA" placeholder="Ingresar el nombre del transportita" required>
                                <div class="invalid-feedback"></div>
                            </div>
                       
                            <div class="mb-3">
                                <label for="DNI_TRANSPORTISTA">Numero de Identidad</label>
                                <input type="text" id="DNI_TRANSPORTISTA" class="form-control" name="DNI_TRANSPORTISTA" placeholder="Ingresar el numero de identidad" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="TEL_TRANSPORTISTA">Numero de Telefono</label>
                                <input type="text" id="TEL_TRANSPORTISTA" class="form-control" name="TEL_TRANSPORTISTA" placeholder="Ingresar el numero de telefono" required>
                                <div class="invalid-feedback"></div>
                            </div>

                             <div class="mb-3">
                                <label for="MAR_VEHICULO">Marca del Vehiculo</label>
                                <input type="text" id="MAR_VEHICULO" class="form-control" name="MAR_VEHICULO" placeholder="Ingresar la marca del vehiculo" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="MOD_VEHICULO"> Modelo del Vehiculo</label>
                                <input type="text" id="MOD_VEHICULO" class="form-control" name="MOD_VEHICULO" placeholder="Ingresar el modelo del vehiculo" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="MAT_VEHICULO">Matricula del Vehiculo</label>
                                <input type="text" id="MAT_VEHICULO" class="form-control" name="MAT_VEHICULO" placeholder="Ingresar la matricula del vehiculo" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="COL_VEHICULO">Color del Vehiculo</label>
                                <input type="text" id="COL_VEHICULO" class="form-control" name="COL_VEHICULO" placeholder="Ingresar el color del vehiculo" required>
                                <div class="invalid-feedback"></div>
                            </div>

                             <div class="mb-3">
                                <label for="MON_TRASLADO">Monto del traslado</label>
                                <input type="text" id="MON_TRASLADO" class="form-control" name="MON_TRASLADO" placeholder="Ingresar el monto del traslado" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                        
                                <label for="COD_FIERRO">Codigo del fierro</label>
                                <input type="text" id="COD_FIERRO" class="form-control" name="COD_FIERRO" placeholder="Ingresar el codigo del Fierro" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="CAN_GANADO">Cantidad de Animales</label>
                                <input type="text" id="CAN_GANADO" class="form-control" name="CAN_GANADO" placeholder="Ingresar la cantidad de animales" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                    </form>

                    <script>
                        $(document).ready(function() {
                             //Validaciones del campo Fecha de Traslado el cual no permitira el ingreso de una fecha anterior al dia de registro
                            $('#FEC_TRASLADO').on('input', function() {
                                var fechaTraslado = $(this).val();
                                var currentDate = new Date().toISOString().split('T')[0];
                                var errorMessage = 'La fecha debe ser válida y no puede ser anterior a hoy';
                                
                                if (!fechaTraslado || fechaTraslado < currentDate) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });

                          //Validaciones del campo direccion de Origen de Traslado
                            $('#DIR_ORIG_PTRASLADO').on('input', function() {
                                var direccionOrigen = $(this).val();
                                var errorMessage = 'La dirección debe tener al menos 5 caracteres';
                                
                                if (direccionOrigen.length < 5) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                              
                             //Validaciones del campo direccion de Destino de Traslado
                            $('#DIR_DEST_TRASLADO').on('input', function() {
                                var direccionDestino = $(this).val();
                                var errorMessage = 'La dirección debe tener al menos 5 caracteres';
                                
                                if (direccionDestino.length < 5) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            
                            //Validaciones del nombre del Trasnportista, no permite que se ingrese numeros solo letras
                            $('#NOM_TRANSPORTISTA').on('input', function() {
                                        var nombre = $(this).val();
                                        var errorMessage = 'El nombre debe tener al menos 5 letras';
                                        if (nombre.length < 5 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                            $(this).addClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text(errorMessage);
                                        } else {
                                            $(this).removeClass('is-invalid');
                                            $(this).siblings('.invalid-feedback').text('');
                                        }
                            });

                            //Validaciones del campo DNI el cual no permite el ingreso de letras (las bloquea y no se muestra)
                            //y solo permite el ingreso de numeros
                            $('#DNI_TRANSPORTISTA').on('input', function() {
                                var dniTransp = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                $(this).val(dniTransp); // Actualizar el valor del campo solo con números
                                var errorMessage = 'El DNI debe contener solo numeros ejemplo:0701199800027 ';
                                if (dniTransp.length !== 13) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            //Validaciones del campo Telefono en el cual no permite el ingreso de letras (las bloquea y no se muestra)
                            //y solo permite el ingreso de numeros
                            $('#TEL_TRANSPORTISTA').on('input', function() {
                                var telefono = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                $(this).val(telefono); // Actualizar el valor del campo solo con números
                                var errorMessage = 'El teléfono debe tener exactamente 8 dígitos numéricos ';
                                if (telefono.length !== 8) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });

                        //Deshabilitar el envio de formularios si hay campos no validos
                        (function () {
                            'use strict'
                            //Obtener todos los formularios a los que queremos aplicar estilos de validacion de Bootstrap
                            var forms = document.querySelectorAll('.needs-validation')
                            //Bucle sobre ellos y evitar el envio
                            Array.prototype.slice.call(forms)
                                .forEach(function (form) {
                                    form.addEventListener('submit', function (event) {
                                        if (!form.checkValidity()) {
                                            event.preventDefault()
                                            event.stopPropagation()
                                        }

                                        form.classList.add('was-validated')
                                    }, false)
                                })
                        })()
                        //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                        function limpiarFormulario() {
                           
                            
                            document.getElementById("FEC_TRASLADO").value = "";
                            document.getElementById("COD_PERSONA").value = "";
                            document.getElementById("DIR_ORIG_PTRASLADO").value = "";
                            document.getElementById("DIR_DEST_TRASLADO").value = "";
                            document.getElementById("NOM_TRANSPORTISTA").value = "";
                            document.getElementById("DNI_TRANSPORTISTA").value = "";
                            document.getElementById("TEL_TRANSPORTISTA").value = "";
                            document.getElementById("MAR_VEHICULO").value = "";
                            document.getElementById("MOD_VEHICULO").value = "";
                            document.getElementById("MAT_VEHICULO").value = "";
                            document.getElementById("COL_VEHICULO").value = "";
                            document.getElementById("MON_TRASLADO").value = "";
                            document.getElementById("COD_DTRASLADO").value = "";
                            document.getElementById("COD_FIERRO").value = "";
                            document.getElementById("CAN_GANADO").value = "";
                               
                            const invalidFeedbackElements = document.querySelectorAll(".invalid-feedback");
                            invalidFeedbackElements.forEach(element => {
                                element.textContent = "";
                            });

                            const invalidFields = document.querySelectorAll(".form-control.is-invalid");
                            invalidFields.forEach(field => {
                                field.classList.remove("is-invalid");
                            });
                        }

                        document.getElementById("btnCancelar").addEventListener("click", function() {
                            limpiarFormulario();
                        });

                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

        <table width=100% cellspacing="14" cellpadding="14" class="table table-hover table-responsive   mt-1" id="traslado">
        <thead>
            <tr>
                <th>Nº</th>                
                <th><center>Fecha de Registro</center></th>
                <th><center>Fecha de Traslado</center></th>
                <th><center>Nombre de la persona</center></th>
                <th><center>Direccion de Origen</center></th>
                <th><center>Direccion de Destino</center></th>
                <th><center>Nombre de Transportista</center></th>
                <th><center>Identidad del Transportista</center></th>
                <th><center>Telefono del Transportista</center></th>
                <th><center>Marca del Vehiculo</center></th>
                <th><center>Modelo del Vehiculo</center></th>
                <th><center>Matricula del Vehiculo</center></th>
                <th><center>Color del Vehiculo</center></th>
                <th><center>Monto del Traslado</center></th>                 
                <th><center>Opciones de la Tabla</center></th>
            </tr>
        </thead>
        <tbody>

            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $PTraslado)
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $PTraslado['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
                <tr>    
                    <td>{{$PTraslado['COD_PTRASLADO']}}</td> 
                    <td>{{date('d/m/y',strtotime($PTraslado['FEC_REG_PTRASLADO']))}}</td>              
                    <td>{{date('d/m/y',strtotime($PTraslado['FEC_TRASLADO']))}}</td>
                    <td>
                        @if ($persona !== null)
                            {{ $persona['NOM_PERSONA']  }}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                    <td>{{$PTraslado['DIR_ORIG_PTRASLADO']}}</td>
                    <td>{{$PTraslado['DIR_DEST_TRASLADO']}}</td>
                    <td>{{$PTraslado['NOM_TRANSPORTISTA']}}</td>
                    <td>{{$PTraslado['DNI_TRANSPORTISTA']}}</td>
                    <td>{{$PTraslado['TEL_TRANSPORTISTA']}}</td>
                    <td>{{$PTraslado['MAR_VEHICULO']}}</td>
                    <td>{{$PTraslado['MOD_VEHICULO']}}</td>
                    <td>{{$PTraslado['MAT_VEHICULO']}}</td>
                    <td>{{$PTraslado['COL_VEHICULO']}}</td>
                    <td>{{$PTraslado['MON_TRASLADO']}}</td>
                    <td>
                    @if(session()->has('PRM_ACTUALIZAR') && session('PRM_ACTUALIZAR') == "S")
                        <button value="Editar" title="Editar" class="btn btn-sm btn-warning"  type="button" data-toggle="modal" data-target="#PTraslado-edit-{{$PTraslado['COD_PTRASLADO']}}">
                        <i class="fa-solid fa-pen-to-square" style='font-size:15px'></i>
                        </button>
                    @endif
                    <a href="{{ route('PTraslado.pdfTraslado') }}" class="btn btn-sm btn-danger" data-target="#PTraslado-edit-{{ $PTraslado['COD_PTRASLADO'] }}" target="_blank">

                                        <i class="fa-solid fa-file-pdf" style="font-size: 15px"></i>
                                        </a>
                        
                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="PTraslado-edit-{{$PTraslado['COD_PTRASLADO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar Datos</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresa los Nuevos Datos</p>
                                <form action="{{ url('ptraslado/actualizar') }}" method="post" class="row g-3 needs-validation" novalidate>
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_PTRASLADO" value="{{$PTraslado['COD_PTRASLADO']}}">

                                        <div class="mb-3 mt-3">
                                            <label for="PTraslado" class="form-label">Fecha de Traslado</label>
                                            <input type="date" class="form-control" id="FEC_TRASLADO" name="FEC_TRASLADO" placeholder="Inserte la fecha del Traslado" value="{{$PTraslado['FEC_TRASLADO']}}" required>
                                            <div class="valid-feedback"></div>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="COD_PERSONA" class="form-label">Persona: </label>
                                            <select class="form-select" id="COD_PERSONA" name="COD_PERSONA" required>
                                            <option value="" disabled selected>Seleccione una Persona</option>
                                           @foreach ($personasArreglo as $persona)
                                            <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOM_PERSONA'] }} </option>
                                            @endforeach
                                        </select>
                                       </div>
                                        

                                        <div class="mb-3">
                                            <label for="PTraslado">Direccion de Origen</label>
                                            <input type="text" class="form-control" id="DIR_ORIG_PTRASLADO" name="DIR_ORIG_PTRASLADO" placeholder="Ingresar la direccion de origen del traslado" value="{{$PTraslado['DIR_ORIG_PTRASLADO']}}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="PTraslado">Direccion de Destino</label>
                                            <input type="text" class="form-control" id="DIR_DEST_TRASLADO" name="DIR_DEST_TRASLADO" placeholder="Ingresar la direccion de destino del traslado" value="{{$PTraslado['DIR_DEST_TRASLADO']}}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="PTraslado">Nombre de Transportista</label>
                                            <input type="text" class="form-control" id="NOM_TRANSPORTISTA" name="NOM_TRANSPORTISTA" placeholder="Ingresar el nombre del transportita" value="{{$PTraslado['NOM_TRANSPORTISTA']}}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="PTraslado">Identidad del Transportista</label>
                                            <input type="text" class="form-control" id="DNI_TRANSPORTISTA" name="DNI_TRANSPORTISTA" placeholder="Ingresar el numero de identidad" value="{{$PTraslado['DNI_TRANSPORTISTA']}}">
                                        </div>

                                         <div class="mb-3">
                                            <label for="PTraslado">Telefono del Transportista</label>
                                            <input type="text" class="form-control" id="TEL_TRANSPORTISTA" name="TEL_TRANSPORTISTA" placeholder="Ingresar el numero de telefono" value="{{$PTraslado['TEL_TRANSPORTISTA']}}">
                                        </div> 

                                         <div class="mb-3">
                                            <label for="PTraslado">Marca del Vehiculo</label>
                                            <input type="text" class="form-control" id="MAR_VEHICULO" name="MAR_VEHICULO" placeholder="Ingresar la marca del vehiculo" value="{{$PTraslado['MAR_VEHICULO']}}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="PTraslado">Modelo del Vehiculo</label>
                                            <input type="text" class="form-control" id="MOD_VEHICULO" name="MOD_VEHICULO" placeholder="Ingresar el modelo del vehiculo" value="{{$PTraslado['MOD_VEHICULO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="PTraslado">Matricula del Vehiculo</label>
                                            <input type="text" class="form-control" id="MAT_VEHICULO" name="MAT_VEHICULO" placeholder="Ingresar la matricula del vehiculo" value="{{$PTraslado['MAT_VEHICULO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="PTraslado">Color del Vehiculo</label>
                                            <input type="text" class="form-control" id="COL_VEHICULO" name="COL_VEHICULO" placeholder="Ingresar el color del vehiculo" value="{{$PTraslado['COL_VEHICULO']}}">
                                        </div>

                                         <div class="mb-3">
                                            <label for="PTraslado">Monto del Traslado</label>
                                            <input type="text" class="form-control" id="MON_TRASLADO" name="MON_TRASLADO" placeholder="Ingresar el monto del traslado" value="{{$PTraslado['MON_TRASLADO']}}">
                                        </div>
                                    
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Editar</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Eliminar -->
                <div class="modal fade" id="ptraslado-delete-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar este registro?
                                </div>
                                    <div class="modal-footer">
                                        <form id="delete-form" method="post">
                                            @csrf
                                                @method('DELETE')
                                                    <input type="hidden" name="delete_id" id="delete_id"> <!-- Agrega este campo oculto, donde almacena el Id del registro que se va a eeliminar-->
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>
    <!-- MENSAJE BAJO -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            2023 &copy; SOFTEAM  
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a>Version 1.0</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- FIN MENSAJE -->
@stop

@section('js')
   <script> console.log('Hi!'); </script>
   <script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
            
            <script>
            $(document).ready(function() {
                $('#traslado').DataTable({
                    responsive: true,
                        dom: "Bfrtilp",
                        buttons: [//Botones de Excel, PDF, Imprimir
                            {
                                extend: "excelHtml5",
                                text: "<i class='fa-solid fa-file-excel'></i>",
                                tittleAttr: "Exportar a Excel",
                                className: "btn btn-success",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                },
                            },
                            {
                                extend: "pdfHtml5",
                                text: "<i class='fa-solid fa-file-pdf'></i>",
                                tittleAttr: "Exportar a PDF",
                                className: "btn btn-danger",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                },
                            },
                            {
                                extend: "print",
                                text: "<i class='fa-solid fa-print'></i>",
                                tittleAttr: "Imprimir",
                                className: "btn btn-secondary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6] //exportar solo la primera hasta las sexta tabla
                                },
                            },
                        ],
                        lengthMenu : [10, 20, 30, 40, 50],
                        language: {
                            processing: "Procesando...",
                            lengthMenu: "Mostrar _MENU_ registros",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable: "Ningún dato disponible en esta tabla",
                            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                            infoFiltered: "(filtrado de un total de _MAX_ registros)",
                            search: "Buscar:",
                            infoThousands: ",",
                            loadingRecords: "Cargando...",
                            paginate: {
                                first: "Primero",
                                last: "Último",
                                next: "Siguiente",
                                previous: "Anterior",
                            },
                            buttons: {
                                copy: "Copiar",
                                colvis: "Visibilidad",
                                collection: "Colección",
                                colvisRestore: "Restaurar visibilidad",
                                copyKeys: "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                                copySuccess: {
                                    1: "Copiada 1 fila al portapapeles",
                                    _: "Copiadas %ds fila al portapapeles",
                                },
                                pdf: "PDF",
                                print: "Imprimir",
                            },
                        },
                });
            });
        </script>
    </script>
    <script>
        // Manejar el clic en el botón de eliminar
        $('.btn-outline-danger').on('click', function() {
                    var deleteId = $(this).data('id');
                    $('#delete_id').val(deleteId);
                });
            });
        //Función para confirmar eliminación
        function confirmDelete(id) {
            $('#psacrificio-delete-confirm').modal('show');
            $('#delete-form').attr('action', '{{ url("psacrificio/eliminar") }}/' + id);
        }
    </script> 
@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@else
       <p>No tiene autorización para visualizar esta sección</p>
@endif
@else
    <!-- Contenido para usuarios no autenticados -->
    <script>
        window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
    </script>
@endif
@stop
