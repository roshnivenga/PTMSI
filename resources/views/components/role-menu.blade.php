@role('admin')
    <li>
        <a href="{{ route('admin.userSelection') }}" class="block p-2 w-full rounded-lg hover:bg-[#0055c4] hover:text-white transition duration-200">Manage Community</a>
    </li>
    <li>
        <a href="{{ route('admin.subjects.index') }}" class="block p-2 w-full rounded-lg hover:bg-[#0055c4] hover:text-white transition duration-200">Manage Classes</a>
    </li>
@endrole


@role('tutor')
    <li>
        <a href="{{ route('tutor.material-upload') }}" class="block p-2 w-full rounded-lg hover:bg-[#0055c4] hover:text-white transition duration-200">Manage Materials</a>
    </li>
@endrole
