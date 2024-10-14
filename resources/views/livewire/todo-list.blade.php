@php use Morilog\Jalali\CalendarUtils; @endphp
<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <h2>Create or update Task</h2>
    <br>
    <form class="row g-3" wire:submit.prevent="{{$this->updateMode ? 'update' : 'store'}}">
        <div class="col-auto">
            <label for="title" class="">Title</label>
            <input class="form-control" id="title" type="text" wire:model="title" placeholder="Title">
        </div>
        <div class="col-auto">
            <label for="description" class="">Description</label>
            <textarea id="description" class="form-control" wire:model="description"
                      placeholder="Description"></textarea>
        </div>
        <div class="col-auto">
            <label for="end_date" class="">end_date</label>
            <input class="form-control" type="text" id="end_date" wire:model="end_date">
        </div>
        <div class="col-auto">
            <label for="priority" class="">Priority</label>
            <select class="form-control" wire:model="priority">
                <option value="">select ...</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-info mt-4" type="submit">Save</button>
        </div>
    </form>
    <br><br>
    <hr>
    <h2>Tasks</h2>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <th scope="col">End Date</th>
            <th scope="col">Priority</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($todos as $todo)
            <tr>
                <th scope="row">{{$loop->index+1}}</th>
                <td>{{ $todo->title }}</td>
                <td>{{ $todo->description }}</td>
                <td>
                    <select class="form-control statusChanging">
                        <option value="pending" {{$todo->status=='pending'?'selected':''}}>Pending</option>
                        <option value="completed" {{$todo->status=='completed'?'selected':''}}>Completed</option>
                    </select>

                </td>
                <td>
                    <span
                        class="badge bg-info"> {{ CalendarUtils::strftime("Y/m/d",strtotime($todo->end_date)) }}
                    </span>
                </td>
                <td class="text-{{$todo->priority=='high'?'danger':($todo->priority=='medium'?'success':'warning')}} fw-bold">{{ $todo->priority }}</td>
                <td>
                    <button class="btn btn-sm btn-secondary" wire:click="edit({{ $todo->id }})">Edit</button>
                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $todo->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
