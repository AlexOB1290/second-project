<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white w-11/12 md:w-96 mx-auto mt-20 rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Вход в личный кабинет</h2>
            <button onclick="closeModal()" class="text-2xl">&times;</button>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-2">Email:</label>
                <input type="email" name="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-2">Пароль:</label>
                <input type="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <button type="submit"
                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                Войти
            </button>
        </form>

        <p class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-red-600">Зарегистрироваться</a>
        </p>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        document.getElementById('loginModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    window.onclick = function(event) {
        const modal = document.getElementById('loginModal');
        if (event.target == modal) {
            closeModal();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Проверяем, что ошибка возникла
        @if ($errors->has('email') || $errors->has('password'))
            @if (!Request::routeIs('login') && !Request::routeIs('register'))  // Убедитесь, что это не страница входа и не страница регистрации
                openModal(); // Открываем модалку только если это не страница входа или регистрации
            @endif
        @endif
    });

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('authForm'); // Убедись, что у формы есть id="authForm"

        if (form) {
            form.addEventListener('submit', function (event) {
                if (document.querySelector('.bg-red-500')) {
                    event.preventDefault(); // Останавливаем закрытие окна при ошибке
                    openModal();
                }
            });
        }
    });
</script>
