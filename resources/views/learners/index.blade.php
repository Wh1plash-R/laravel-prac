<x-layout>
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-200 p-8 mt-10 text-gray-800">
        <h2 class="text-xl font-bold mb-4 text-blue-600">Mentor: {{ $mentor }}</h2>
        <h2 class="text-2xl font-extrabold mb-6">Learners List</h2>
        <ul class="space-y-4">
            @foreach ($learners as $learner)
                <li>
                    <x-card href="{{ route('learners.show', $learner->id) }}" :highlight="$learner->skill == 'PHP' ||
                        $learner->skill == 'C'">
                        {{-- the : before highlight means that we are passing a dynamic value --}}
                        {{-- if we pass a string, we don't need the colon --}}
                        {{-- the highlight prop is set to true if the skill is PHP --}}
                        {{-- the colon before the highlight makes the attribute or prop a dynamic value instead of a string--}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Name: {{ $learner->name }} </h3>
                            <p class="text-gray-600">Skill: {{ $learner->skill? $learner->skill: 'None' }}</p>
                            <p class="text-gray-600">Course: {{ $learner->course? $learner->course->title:'None'}}</p>
                        </div>
                    </x-card>
                </li>
            @endforeach
        </ul>
        <div class="mt-8">
            {{ $learners->links('components.pagination') }}
        </div>
    </div>
</x-layout>
