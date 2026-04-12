<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Asignar Cursos a Alumnos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Asignar nuevo curso</h3>
                    <form action="{{ route('admin.courses.assign.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <select name="user_id" class="border rounded px-3 py-2 flex-1" required>
                            <option value="">Seleccioná un alumno</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">{{ $alumno->name }} ({{ $alumno->email }})</option>
                            @endforeach
                        </select>
                        <select name="course_id" class="border rounded px-3 py-2 flex-1" required>
                            <option value="">Seleccioná un curso</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->titulo }} - {{ $course->materia }} {{ $course->grado }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Asignar</button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Cursos asignados por alumno</h3>
                    @forelse($alumnos as $alumno)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-700 mb-2">{{ $alumno->name }}</h4>
                            @if($alumno->courses->isEmpty())
                                <p class="text-gray-400 text-sm">Sin cursos asignados.</p>
                            @else
                                <table class="w-full text-left mb-2">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="py-1 text-sm">Curso</th>
                                            <th class="py-1 text-sm">Materia</th>
                                            <th class="py-1 text-sm">Grado</th>
                                            <th class="py-1 text-sm">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($alumno->courses as $course)
                                        <tr class="border-b">
                                            <td class="py-1 text-sm">{{ $course->titulo }}</td>
                                            <td class="py-1 text-sm">{{ $course->materia }}</td>
                                            <td class="py-1 text-sm">{{ $course->grado }}</td>
                                            <td class="py-1 text-sm">
                                                <form action="{{ route('admin.courses.assign.destroy') }}" method="POST" onsubmit="return confirm('¿Seguro que querés quitar este curso?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="user_id" value="{{ $alumno->id }}">
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Quitar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">No hay alumnos aprobados todavía.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>