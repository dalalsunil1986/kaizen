<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ! empty($title) ? $title . ' - ' : '' }} Kaizen Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @section('style')

        {{ HTML::style('assets/css/bootstrap.min.css') }}
        {{ HTML::style('css/font-awesome.min.css') }}
{{--        {{ HTML::style('assets/css/wysihtml5/prettify.css') }}--}}
{{--        {{ HTML::style('assets/css/wysihtml5/bootstrap-wysihtml5.css') }}--}}
        {{ HTML::style('packages/froala_editor_1.2.4/css/froala_editor.min.css') }}
        {{ HTML::style('packages/froala_editor_1.2.4/css/froala_style.min.css') }}
        {{ HTML::style('assets/css/datatables.css') }}
        {{ HTML::style('assets/css/custom.css') }}

        <style>
            .container-fluid {
                padding:0 50px;
            }
        </style>
    @show


</head>

<body>
<!-- Container -->
<div class="container-fluid ">

    @include('admin.partials.navigation')
    @include('admin.partials.confirm')
    <!-- ./ navbar -->

    <!-- Notifications -->
    @include('admin.partials.notification')
    <!-- ./ notifications -->

    <!-- Content -->
    @section('content')
    @show
    <!-- ./ content -->

    <!-- Footer -->
    @include('admin.layouts.footer')
    <!-- ./ Footer -->


</div>
<!-- ./ container -->

    <!-- Javascript -->
    @section('script')


    {{ HTML::script('assets/js/jquery.min.js') }}
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{--{{ HTML::script('assets/js/wysihtml5/wysihtml5-0.3.0.js') }}--}}
    {{--{{ HTML::script('assets/js/wysihtml5/bootstrap-wysihtml5.js') }}--}}
    {{ HTML::script('assets/js/nicEdit.js') }}
    {{ HTML::script('assets/js/datatables-bootstrap.js') }}
    {{ HTML::script('assets/js/datatables.js') }}
    {{ HTML::script('packages/froala_editor_1.2.4/js/froala_editor.min.js') }}

    <script type="text/javascript">
//        $('.wysihtml5').wysihtml5();
//        $('.wysihtml5').Editor();
//        nicEditors.allTextAreas();

//        $('button[name="remove"]').on('click', function(e){
//            var $form=$(this).closest('form');
//            e.preventDefault();
//            $('#confirm').modal({ backdrop: 'static', keyboard: false })
//                .one('click', '#delete', function (e) {
//                    $form.trigger('submit');
//                });
//        });
        $('.delete-btns').on('click', function(e){
            var $form=$(this).closest('form');
                e.preventDefault();
                $('#confirm').modal({ backdrop: 'static', keyboard: false })
                    .one('click', '#delete', function (e) {
                        $form.trigger('submit');
                    }
                );
        });
        $(document).ready(function() {
            $('.datatable').dataTable({
                "sPaginationType": "bs_four_button",
                "iDisplayLength" : 100
            });
            $('.datatable').each(function(){
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.addClass('form-control');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.addClass('form-control input-sm');
            });
//            nicEditors.allTextAreas();
        });

//$(function(){
//    $('.wysihtml5').editable({
//        inlineMode:false,
//        buttons: ["bold", "italic", "underline", "strikeThrough", "subscript", "superscript", "fontFamily", "fontSize", "color", "formatBlock", "blockStyle", "align", "insertOrderedList", "insertUnorderedList", "outdent", "indent", "selectAll", "createLink", "insertImage", "insertVideo", "undo", "removeFormat", "redo", "html", "insertHorizontalRule", "table", "uploadFile", 'rightToLeft', 'leftToRight'],
//
//        customButtons: {
//            // Right to left button.
//            rightToLeft: {
//                title: "rtl",
//                icon: {
//                    type: "font",
//                    value: "fa fa-long-arrow-right" // Font Awesome icon class fa fa-*
//                },
//                callback: function () {
//                    this.saveSelectionByMarkers();
//                    var selectedElements = this.getSelectionElements();
//                    var containerDiv = document.createElement("div");
//                    containerDiv.dir = "rtl";
//                    containerDiv.style.textAlign = "right";
//                    $(selectedElements[0]).before(containerDiv);
//
//                    for(var i = 0; i < selectedElements.length; i++) {
//                        containerDiv.appendChild(selectedElements[i]);
//                    }
//
//                    this.restoreSelectionByMarkers();
//                    this.saveUndoStep();
//                }
//            },
//            // Left to right button.
//            leftToRight: {
//                title: "ltr",
//                icon: {
//                    type: "font",
//                    value: 'fa fa-long-arrow-left' // Font Awesome icon class fa fa-*
//                },
//                callback: function () {
//                    this.saveSelectionByMarkers();
//                    var selectedElements = this.getSelectionElements();
//                    var containerDiv = document.createElement("div");
//                    containerDiv.dir = "ltr";
//                    containerDiv.style.textAlign = "left";
//                    $(selectedElements[0]).before(containerDiv);
//
//                    for(var i = 0; i < selectedElements.length; i++) {
//                        containerDiv.appendChild(selectedElements[i]);
//                    }
//
//                    this.restoreSelectionByMarkers();
//                    this.saveUndoStep();
//                }
//            }
//        }
//    })
//})
    tinymce.init({
        selector: "textarea.wysihtml5",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor jbimages"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | print preview media fullpage | forecolor backcolor emoticons",
        relative_urls : false

    });
    </script>

    @show

</body>

</html>