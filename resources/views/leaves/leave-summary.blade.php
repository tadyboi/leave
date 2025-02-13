<?php
/**
 * Created by PhpStorm for wls
 * User: Vincent Guyo
 * Date: 10/16/2019
 * Time: 14:44
 */
?>

@extends('layouts.app')

@section('template_title')
    Showing Leave Summary
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Approved Leave Summary
                            </span>

                            <div class="btn-group pull-right btn-group-xs">

                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive users-table">
                            <table id="data-table" class="table table-striped table-sm data-table">

                                <thead class="thead">
                                <tr>
                                    <th>Pay Number</th>
                                    <th class="hidden-xs">Name </th>
                                    <th>Department </th>
                                    <th>Type of Leave</th>
                                    <th>Total Days Taken</th>
                                </tr>
                                </thead>
                                <tbody id="users_table">
                                @foreach($leaves as $leave)
                                    @php
                                        $users = \App\Models\User::all()->where('paynumber', $leave->paynumber );
                                    @endphp
                                    <tr>
                                        <td>{{$leave->paynumber}}</td>
                                        @foreach($users as $user)
                                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                                        @endforeach
                                        <td>{{$leave->department}}</td>
                                        <td>{{$leave->type_of_leave}}</td>
                                        <td >{{$leave->sum}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tbody id="search_results"></tbody>
                                @if(config('usersmanagement.enableSearchUsers'))
                                    <tbody id="search_results"></tbody>
                                @endif

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.data-table').dataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "dom": 'lBfrtip',
                    "buttons": [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    "sPaginationType": "full_numbers",
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'searchable': false,
                        'aTargets': ['no-search'],
                        'bTargets': ['no-sort']
                    }]
                });
            });
        </script>
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('usersmanagement.enableSearchUsers'))
        @include('scripts.search-leave')
    @endif
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
@endsection

