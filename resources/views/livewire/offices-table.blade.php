<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>Offices</strong>
                    <a href="{{ route('admin.offices.create') }}" class="btn btn-sm btn-success">Create</a>
                    <small>
                        {!! $search ? 'Showing '. $offices->total() .' results for <strong>' . $search .'</strong>' : '' !!}
                    </small>
                    <div class="card-header-actions">
                        <input wire:model="search" class="form-control form-control-sm" type="search" placeholder="Search..." style="width: 200px;">
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('id')" role="button" href="#">
                                    #
                                    @include('includes.sort-icon', ['field' => 'id'])
                                </a>
                            </th>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                    Name
                                    @include('includes.sort-icon', ['field' => 'name'])
                                </a>
                            </th>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('operating_unit_id')" role="button" href="#">
                                    Operating Unit
                                    @include('includes.sort-icon', ['field' => 'operating_unit_id'])
                                </a>
                            </th>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('acronym')" role="button" href="#">
                                    Acronym
                                    @include('includes.sort-icon', ['field' => 'acronym'])
                                </a>
                            </th>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('email')" role="button" href="#">
                                    Email
                                    @include('includes.sort-icon', ['field' => 'email'])
                                </a>
                            </th>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('contact_numbers')" role="button" href="#">
                                    Contact Nos.
                                    @include('includes.sort-icon', ['field' => 'contact_numbers'])
                                </a>
                            </th>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('office_head_name')" role="button" href="#">
                                    Head of Office
                                    @include('includes.sort-icon', ['field' => 'office_head_name'])
                                </a>
                            </th>
                            <th class="text-center text-sm text-nowrap">
                                <a wire:click.prevent="sortBy('office_head_position')" role="button" href="#">
                                    Designation
                                    @include('includes.sort-icon', ['field' => 'office_head_position'])
                                </a>
                            </th>
                            <th class="text-center text-sm">Focals</th>
                            <th class="text-center text-sm">Reviewers</th>
                            <th class="text-center text-sm"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($offices as $office)
                            <tr>
                                <td>{{ $office->id }}</td>
                                <td class="text-center text-sm">{{ $office->name }}</td>
                                <td class="text-center text-sm">{{ $office->operating_unit->name ?? '' }}</td>
                                <td class="text-center text-sm">{{ $office->acronym }}</td>
                                <td class="text-center text-sm">{{ $office->email }}</td>
                                <td class="text-center text-sm">{{ $office->contact_numbers }}</td>
                                <td class="text-center text-sm">{{ $office->office_head_name }}</td>
                                <td class="text-center text-sm">{{ $office->office_head_position }}</td>
                                <td>
                                    @foreach($office->users as $user)
                                        <span class="badge badge-primary">
                                        {{ $user->first_name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($office->reviewers as $reviewer)
                                        <span class="badge badge-success">
                                        {{ $reviewer->first_name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-sm btn-dark">Edit</a>
                                    <a href="{{ route('admin.offices.assign_reviewer', $office) }}" class="btn btn-sm btn-outline-dark">Assign</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-sm text-center text-danger">
                                    No audit log found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <p class="text-muted float-left">
                        <strong>Note: </strong>Offices refers to the Office the user belongs to (e.g. program, division, project office, unit, etc). Operating units, on the other hand, map directly to the operating units accounted in the GAA.
                    </p>

                    <div class="float-right">
                        {{ $offices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
