<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>

@extends('<?=config('llstarscreamll.CrudGenerator.config.layout')?>')

@section('title') {{trans('<?=$gen->getLangAccess()?>/views.module.name')}} @endsection

@section('style')
@endsection

@section('content')
    
    <section class="content-header">
        <h1>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
        </h1>
    </section>

    <section class="content">
    
        <div class="box">
            
            <div class="box-header">
                
                <div class="row tools">

                    {{-- Action Buttons --}}
                    <div class="col-md-6 action-buttons">
<?php
///////////////////////////////////////////////////////////
// creamos formulario para eliminar registros masivamete //
///////////////////////////////////////////////////////////
?>
                    {{-- Formulario para restablecer resgistros masivamente --}}
                    {!! Form::open(['route' => ['<?=$gen->route()?>.destroy'], 'method' => 'DELETE', 'id' => 'deleteMassivelyForm', 'class' => 'form-inline display-inline']) !!}
                        
                        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para "eliminar" varios registro a la vez --}}
                        <button title="{{trans('<?=$gen->getLangAccess()?>/views.index.delete-massively-button-label')}}"
                                class="btn btn-default btn-sm massively-action <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                                role="button"
                                data-toggle="tooltip"
                                data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                                {{-- Setup de ventana modal de confirmación --}}
                                data-modalTitle="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-title')}}"
                                data-modalMessage="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-message')}}"
                                data-btnLabel="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-btn-confirm-label')}}"
                                data-btnClassName="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-massively-btn-confirm-class-name')}}"
                                data-targetFormId="deleteMassivelyForm"
<?php } else { ?>
                                onclick="return confirm('{{trans('<?=$gen->getLangAccess()?>/views.index.delete-massively-confirm-message')}}')"
<?php } ?>
                                type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>">
                            <span class="fa fa-trash"></span>
                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.delete-massively-button-label')}}</span>
                        </button>
                    
                    {!! Form::close() !!}

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si la entidad tiene softDeletes podemos añadir la opción de restaurar los registros "borrados" masivamente //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>

                    {{-- Esta opción sólo es mostrada si el usuario decidió consultar los registros "borrados" --}}
                    @if (Request::has('trashed_records'))

                    {{-- Formulario para restablecer resgistros masivamente --}}
                    {!! Form::open(['route' => ['<?=$gen->route()?>.restore'], 'method' => 'PUT', 'id' => 'restoreMassivelyForm', 'class' => 'form-inline display-inline']) !!}
                        
                        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario para restablecer varios registros a la vez --}}
                        <button title="{{trans('<?=$gen->getLangAccess()?>/views.index.restore-massively-button-label')}}"
                                class="btn btn-default btn-sm massively-action <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                                role="button"
                                data-toggle="tooltip"
                                data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                                {{-- Setup de ventana modal de confirmación --}}
                                data-modalTitle="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-title')}}"
                                data-modalMessage="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-message')}}"
                                data-btnLabel="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-btn-confirm-label')}}"
                                data-btnClassName="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-restore-massively-btn-confirm-class-name')}}"
                                data-targetFormId="restoreMassivelyForm"
<?php } else { ?>
                                onclick="return confirm('{{trans('<?=$gen->getLangAccess()?>/views.index.restore-massively-confirm-message')}}')"
<?php } ?>
                                type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>">
                            <span class="fa fa-mail-reply"></span>
                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.restore-massively-button-label')}}</span>
                        </button>
                    
                    {!! Form::close() !!}

                    @endif
<?php } ?>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si se desea que el formulario para crear un nuevo registro esté incluido en la vista del index a través de una ventana modal, //
// el botón de crear disparará la ventana modal                                                                                  //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if (config('llstarscreamll.CrudGenerator.config.show-create-form-on-index') === true) { ?>
                        {{-- El boton que dispara la ventana modal con formulario de creación de registro --}}
                        <div class="display-inline-block" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#create-form-modal">
                                <span class="glyphicon glyphicon-plus"></span>
                                <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}</span>
                            </button>
                        </div>
<?php } else { ?>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////
// de lo contrario será un link que lleve a las vista de create.blade.php con el formulario de creación //
//////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
                        {{-- Link que lleva a la página con el formulario de creación de registro --}}
                        <a id="create-<?=$gen->route()?>-link" class="btn btn-default btn-sm" href="{!! route('<?=$gen->route()?>.create') !!}" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.create-button-label')}}</span>
                        </a>
<?php } ?>
                    
                    </div>

                    @include('<?=config('llstarscreamll.CrudGenerator.config.layout-namespace')?>layout.notifications')

                </div>
                
            </div>
            
            <div class="box-body">

                {{-- La tabla de datos --}}
                @include('<?=$gen->viewsDirName()?>.partials.index-table')

            </div>
        
        </div>    
    
    </section>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
// incluimos el partial con la ventana modal que contiene el fomulario de creación de registro si es el caso //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if (config('llstarscreamll.CrudGenerator.config.show-create-form-on-index') === true) { ?>
    {{-- Formulario de creación de registro --}}
    @include('<?=$gen->viewsDirName()?>.partials.index-create-form')
<?php } ?>

@endsection

@section('script')

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si la entidad tiene campos que tengan que usar un select, incluimos los assets del componente Bootstrap-Select //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasSelectFields($fields)) { ?>
    {{-- Componente Bootstrap-Select, este componente se inicializa automáticamente --}}
    <link href="{{ asset('resources/CoreModule/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('resources/CoreModule/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('resources/CoreModule/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}"></script>
<?php } ?>

    {{-- Componente iCheck --}}
    <link href="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/square/red.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('resources/CoreModule/admin-lte/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si se quiere usar ventanas modales de confirmación para acciones como eliminar registros u otras, incluimos //
// el componente Bootbox para generarles fácilmente y con un setup mínimo                                      //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
    {{-- Componente Bootbox --}}
    <script src="{{ asset('resources/CoreModule/bootbox/bootbox.js') }}" type="text/javascript"></script>
<?php } ?>

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si la entidad tiene campos de fecha incluimos el componente Bootstrap DateRangePicker para lograr de forma //
// sencilla hacer las búsquedas por rangos de fecha                                                           //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
    {{-- Componente Bootstrap DateRangePicker --}}
    <link href="{{ asset('resources/CoreModule/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('resources/CoreModule/admin-lte/plugins/daterangepicker/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('resources/CoreModule/admin-lte/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<?php } ?>

    <script>
<?php
/////////////////////////////////////////////////////////////////////////////////////
// lineas para mejorar el comportamiento de selección de los elementos de la tabla //
/////////////////////////////////////////////////////////////////////////////////////
?>
        $(document).ready(function(){
            {{-- searching if there are checkboxes checked to toggle enable action buttons --}}
            scanCheckedCheckboxes('.checkbox-table-item');
            
            {{-- toggle the checkbox checked state from row click --}}
            toggleCheckboxFromRowClick();
            
            {{-- toggle select all checkboxes --}}
            toggleCheckboxes();
            
            {{-- listen click on checkboxes to change row class and count the ones checked --}}
            $('.checkbox-table-item').click(function(event) {
                scanCheckedCheckboxes('.'+$(this).attr('class'));
                event.stopPropagation();
            });
        });
<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lineas para prevenir comportamiento por defecto de los dropdowns de Bootstrap al seleccionar uno de los elementos //
// que contiene, esto sólo para el caso del botón #filter donde se puede seleccionar opciones de filtros para las    //
// búsquedas                                                                                                         //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
        {{-- Previene que se esconda el menú del dropdown al hacer clic a sus elementos hijos --}}
        $('#filters .dropdown-menu input, #filters .dropdown-menu label').click(function(e) {
            e.stopPropagation();
        });

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////
// creamos las variables regionales y algunos rango de fechas pedeterminados para el componente Bootstrap //
// DateRangePicker si es que hay campos de fecha                                                          //
////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
        {{-- Configuración regional para Bootstrap DateRangePicker --}}
        dateRangePickerLocaleSettings = {
            applyLabel: '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.applyLabel') !!}',
            cancelLabel: '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.cancelLabel') !!}',
            fromLabel: '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.fromLabel') !!}',
            toLabel: '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.toLabel') !!}',
            separator: '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.separator') !!}',
            weekLabel: '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.weekLabel') !!}',
            customRangeLabel: '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.customRangeLabel') !!}',
            daysOfWeek: {!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.daysOfWeek') !!},
            monthNames: {!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.monthNames') !!},
            firstDay: {!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.firstDay') !!}
        };

        dateRangePickerRangesSettings = {
            '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.range_today') !!}': [moment(), moment()],
            '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.range_yesterday') !!}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.range_last_7_days') !!}': [moment().subtract(6, 'days'), moment()],
            '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.range_last_30_days') !!}': [moment().subtract(29, 'days'), moment()],
            '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.range_this_month') !!}': [moment().startOf('month'), moment().endOf('month')],
            '{!! trans('<?=$gen->getLangAccess()?>/views.index.dateRangePicker.range_last_month') !!}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        };

        {{-- Configuración de Bootstrap DateRangePicker --}}
<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// creamos el setup de Bootstrap DateRangePicker para cada campo de tipo fecha y fecha y hora que haya en la entidad //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->type == 'date') { ?>
        $('input[name="<?= $field->name ?>[informative]"]').daterangepicker({
            opens: 'center',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        }, function(start, end, label) {
            $('input[name="<?= $field->name ?>[from]"]').val(start.format('YYYY-MM-DD'));
            $('input[name="<?= $field->name ?>[to]"]').val(end.format('YYYY-MM-DD'));
        });
<?php } elseif ($field->type == 'timestamp' || $field->type == 'datetime') { ?>
        $('input[name="<?= $field->name ?>[informative]"]').daterangepicker({
            format: 'MM/DD/YYYY HH:mm:ss',
            timePicker: true,
            timePickerIncrement: 1,
            opens: 'left',
            locale: dateRangePickerLocaleSettings,
            ranges: dateRangePickerRangesSettings
        }, function(start, end, label) {
            $('input[name="<?= $field->name ?>[from]"]').val(start.format('YYYY-MM-DD HH:mm:ss'));
            $('input[name="<?= $field->name ?>[to]"]').val(end.format('YYYY-MM-DD HH:mm:ss'));
        });
<?php } // end if ?>
<?php } // end foreach ?>
<?php } // end if ?>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// el setup del componente Bootbox para las ventanas modales de confirmación y demás, si es que se especificó su uso //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
        {{-- Configuración Bootbox, ver mas opciones para el método dialog aquí: https://gist.github.com/makeusabrew/6339780  --}}
        $(document).on("click", ".bootbox-dialog", function(e) {

            // el botón clickeado
            buttonTarget = $(e.currentTarget);
            // el título de la ventana modal
            title = $(e.currentTarget).attr('data-modalTitle');
            // el mensaje a mostrar dentro de la ventana modal
            message = $(e.currentTarget).attr('data-modalMessage');
            // el label del botón de confirmación
            btnLabel = $(e.currentTarget).attr('data-btnLabel');
            // la clase del botón de confirmación
            btnClassName = $(e.currentTarget).attr('data-btnClassName');
            // la clase adicional para la ventana modal
            modalClassName = $(e.currentTarget).attr('data-modalClassName');
            // el formulario al que serán asociados los checkbox de la tabla, si es que se especifica
            targetFormId = $(e.currentTarget).attr('data-targetFormId');

            // título por defecto
            if (!title) {
                title = '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-title')}}';
            }

            // label del botón de confirmación por defecto
            if (!btnLabel) {
                btnLabel = '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-confirmation-label')}}';
            }

            // clase del botón de confirmación por defecto
            if (!btnClassName) {
                btnClassName = '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-confirmation-className')}}';
            }
            
            bootbox.dialog({
              /**
               * @required String|Element
               */
              message: message,
              
              /**
               * @optional String|Element
               * adds a header to the dialog and places this text in an h4
               */
              title: title,
              
              /**
               * @optional String
               * @default: null
               * an additional class to apply to the dialog wrapper
               */
              className: modalClassName,
              
              /**
               * @optional Object
               * @default: {}
               * any buttons shown in the dialog's footer
               */
              buttons: {
                // For each key inside the buttons object...
                
                /**
                 * @required Object|Function
                 * 
                 * this first usage will ignore the `cancel` key
                 * provided and take all button options from the given object
                 */
                cancel: {
                    /**
                   * @required String
                   * this button's label
                   */
                  label: '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-cancel-label')}}',
                  
                  /**
                   * @optional String
                   * an additional class to apply to the button
                   */
                  className: '{{trans('<?=$gen->getLangAccess()?>/views.index.modal-default-btn-cancel-className')}}',
                  
                  /**
                   * @optional Function
                   * the callback to invoke when this button is clicked
                   */
                  callback: function() {}
                },

                /**
                 * @required Object|Function
                 * 
                 * this first usage will ignore the `success` key
                 * provided and take all button options from the given object
                 */
                success: {
                  /**
                   * @required String
                   * this button's label
                   */
                  label: btnLabel,
                  
                  /**
                   * @optional String
                   * an additional class to apply to the button
                   */
                  className: btnClassName,
                  
                  /**
                   * @optional Function
                   * the callback to invoke when this button is clicked
                   */
                  callback: function() {
                    
                    // si se ha dado algún id de formulario al que deban estar asociados los
                    // checkboxes de la tabla, los asocio a dicho formulario
                    if (targetFormId) {
                        $('.checkbox-table-item').attr('form', targetFormId);
                    }

                    // envíamos el formulario relacionado al botón
                    buttonTarget.closest('form').submit();

                  }
                }
              }
            });

        });
<?php } ?>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si hay campos de tipo booleano inicializamos el componente BootstrapSwitch y iCheck los cualales son usados en el formulario de //
// creación de un registro de ĺa entidad y en los campos del formulario de búsqueda avanzada en la tabla                           //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasTinyintTypeField($fields)) { ?>
        {{-- Inicializa el componente BootstrapSwitch --}}
        $(".bootstrap_switch").bootstrapSwitch();

        {{-- Inicializa el componente iCheck --}}
        $('.icheckbox_square-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
        $('.icheckbox_square-red').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red'
        });
<?php } ?>
    </script>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inclusión y Setup del componente Bootstrap DateTimePicker si es que hay campos de tipo fecha/fecha y hora en la entidad //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
    {{-- Componente Bootstrap DateTimePicker --}}
    <link rel="stylesheet" href="{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
    <script src="{{ asset('resources/CoreModule/moment/min/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('resources/CoreModule/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<?php } ?>

<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
<script>

        {{-- Configuración de Bootstrap DateTimePicker --}}
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->type == 'date' && $field->on_create_form) { ?>
        $('input[name=<?= $field->name ?>]').datetimepicker({
            locale: '{{ Lang::locale() }}',
            format: 'YYYY-MM-DD'
        });
<?php } elseif (($field->type == 'timestamp' || $field->type == 'datetime') && $field->on_create_form) { ?>
        $('input[name=<?= $field->name ?>]').datetimepicker({
            locale: '{{Lang::locale()}}',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
<?php } // end if ?>
<?php } // end foreach ?>

</script>
<?php } // end if ?>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inclusión y setup de componente Bootstrap 3 Editable, el setup comprende también algunos parámetros para los campos //
// de tipo fecha/fecha y hora si es que los hay                                                                        //
// NOTA:                                                                                                               //
// - Muy importante dejar este componente aquí pues el compoente que usa Bootstrap 3 Editable para las fechas hace     //
//   colición con el compoente Bootstrap DateTimePicker, ambos usan los mismos nombres...                              //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
{{-- Componente Bootstrap 3 Editable --}}
    <link href="{{ asset('resources/CoreModule/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('resources/CoreModule/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

<?php if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields)) { ?>
    {{-- Dependencias de datetimepicker para componente x-editable --}}
    <link href="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('resources/CoreModule/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js') }}"></script>
<?php } ?>
  
    <script>
        {{-- Configuración del componente x-editable --}}
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $(".editable").editable({ajaxOptions:{method:'PUT'}});

<?php
// setup Bootstrap 3 Editable para campos de tipo fecha y fecha y hora
?>
<?php if ($gen->hasDateFields($fields)) { ?>
        {{-- Configuración del componente x-editable para el caso de campos de tipo "date" --}}
        $('.editable-date').editable({
            ajaxOptions:{method:'PUT'},
            format: 'yyyy-mm-dd',
            viewformat: 'dd/mm/yyyy',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });
<?php } ?>

<?php if ($gen->hasDateTimeFields($fields)) { ?>
        {{-- Configuración del componente x-editable para el caso de campos de tipo "datetime" --}}
        $('.editable-datetime').editable({
            ajaxOptions:{method:'PUT'},
            format: 'yyyy-mm-dd hh:ii:ss',
            viewformat: 'yyyy-mm-dd hh:ii:ss',
            datetimepicker: {
                todayBtn: 'linked',
                weekStart: 1,
                language: 'es'
            }
        });
<?php } ?>
    </script>

@endsection