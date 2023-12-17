@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Devices/Resources/sass/_devices.scss')
@endsection

@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card">
                    <h3 class="pb-1">Device: </h3>
                    <form method="POST" action="{{ route('devices.mutate.save') }}">
                        @csrf

						@if(isset($device))
							<input type="hidden" name="device_id" value="{{ $device->getId() }}">
						@endif

                        <div class="form-outline">
                            <label class="form-label" for="devicename">Device name</label>
                            <input id="devicename" type="text"
                                   class="form-control rounded-4 form-control-lg @error('devicename') is-invalid @enderror"
                                   name="devicename" value="{{ old('devicename') }}"
                                   required autocomplete="devicename"
                                   autofocus>

                            @error('devicename')
                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                            @enderror
                        </div>
                        <div class="form-outline pt-2">
                            <label class="form-label" for="devicetype">Device type</label>

                            <select class="form-select @error('devicetype') is-invalid @enderror" name="devicetype" aria-label="Default select example">
                                <option selected>Device type</option>
                                <option value="{{\App\Domain\Device\Model\TypeEnum::COMMA}}">Comma</option>
                                <option value="{{\App\Domain\Device\Model\TypeEnum::SIM}}">Simulator</option>
                            </select>

                            @error('devicetype')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-outline pt-2">
                            <input type="submit" value="Save" class="btn btn-success btn-lg btn-block rounded-4">
                        </div>



                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
