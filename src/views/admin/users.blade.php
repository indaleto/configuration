@extends('adminConfiguration::layout.app')

@section('title')
    Dashboard
@endsection

@section('content')

<!-- Ver web routes para get-data-my-datatables -->

			<table class="table table-striped table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
            </table>

@endsection

@section('afterBodyScripts')

        <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('get.users') !!}',
                columns: [
                    { data: 'name', name: 'name' ,orderable: false,"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                                                $(nTd).html("<a href='/admin/users/"+oData.id+"'>"+oData.name+"</a>");
                                            }},
                    { data: 'email', name: 'email',orderable: false },
                ],
                "order": [],
            });
        });
        </script>

@endsection