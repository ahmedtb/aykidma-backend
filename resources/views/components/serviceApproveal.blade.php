<div class="col-5 border border-primary">

    <div class="border border-dark">

        <strong class="">مزود الخدمة</strong>
        <div class="row">

            <img src="{{ $service->ServiceProvider->image }}" class="img-thumbnail w-50 p-1" alt="صورة مزود الخدمة">
            <div class="w-50 p-1">
                <strong class="">{{ $service->ServiceProvider->name }}</strong>
                <div>{{ $service->ServiceProvider->phone_number }}</div>
                <div>{{ $service->ServiceProvider->email }}</div>
                {{-- <div>عنوان مزود الخدمة {{ $service->ServiceProvider->address['city'] }}</div> --}}

                <div class="row">
                    <strong>اماكن التخطية</strong>
                    @foreach ($service->ServiceProvider->coverage as $coverage)
                        <div class="m-1">{{ $coverage['city'] }}</div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>


    <p>This is service {{ $service->id }}</p>
    <p>{{ $service->title }}</p>
    <p>the structure of the fields of the serivce preposed are</p>

    <div class="border border-dark rounded">{!! nl2br($service->description) !!}</div>

    @foreach ($service->array_of_fields->getFields() as $field)

        @if (get_class($field) == OptionsField::class)
            <p class="text-center mb-0">{{ $field['label'] }}</p>
            <div class="border border-dark rounded d-flex flex-row justify-content-around">
                @foreach ($field['titles'] as $title)
                    <p class='mb-0'>{{ $title }} </p>
                @endforeach
            </div>
        @elseif (get_class($field) == ImageField::class)
            <p class="text-center mb-0">{{ $field['label'] }}</p>
            <div class="border border-dark rounded d-flex flex-row justify-content-around p-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                    class="bi bi-camera-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                    <path
                        d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                </svg>
            </div>
        @elseif (get_class($field) == TextAreaField::class)
            <p class="text-center mb-0">{{ $field['label'] }}</p>
            <div class="border border-dark rounded d-flex flex-row justify-content-around p-4">
            </div>
        @endif

    @endforeach

    <div class=" d-flex flex-row justify-content-around">


        {{ Form::open(['url' => '/reject/service', 'method' => 'delete']) }}
        {{ Form::hidden('service_id', $service->id) }}
        <input type="submit" name="lname" class="btn btn-secondary" value="رفض عرض الخدمة">
        {{ Form::close() }}



        {{ Form::open(['url' => '/approve/service', 'method' => 'put']) }}
        {{ Form::hidden('service_id', $service->id) }}

        <input type="submit" name="lname" class="btn btn-success" value="موافقة على تقديم الخدمة">
        {{ Form::close() }}

        {{-- <button type="button" class="btn btn-secondary">رفض عرض الخدمة</button> --}}
        {{-- <button type="button" class="btn btn-success">موافقة على تقديم الخدمة</button> --}}
    </div>
</div>
