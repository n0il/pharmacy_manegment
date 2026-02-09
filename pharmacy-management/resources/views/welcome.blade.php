<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <div class="text-center">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-full mb-4">
                    <i class="fas fa-pills text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Pharmacy Management System
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Модерна система за управление на аптека с пълен контрол върху лекарства, продажби и доставки
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-capsules text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Управление на лекарства</h3>
                        <p class="text-gray-600">Пълен контрол върху наличности, цени и информация за лекарствата</p>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Статистика и отчети</h3>
                        <p class="text-gray-600">Детайлна статистика за продажби и наличности в реално време</p>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-file-medical text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Управление на рецепти</h3>
                        <p class="text-gray-600">Качване и съхранение на цифрови рецепти в PDF формат</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Основни функционалности</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900">Административен панел</h4>
                                <p class="text-gray-600">Пълен CRUD интерфейс за всички обекти</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900">Многопотребителска система</h4>
                                <p class="text-gray-600">Роли и права за достъп</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900">Файлово качване</h4>
                                <p class="text-gray-600">Изображения и PDF с валидация</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900">Модерен UI</h4>
                                <p class="text-gray-600">Responsive дизайн с Tailwind CSS</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Вход в системата
                    </a>
                </div>

                <div class="mt-12 bg-gray-800 rounded-lg p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4">Демо акаунти</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="font-medium">Администратор:</p>
                            <p class="text-gray-300">admin@pharmacy.com / password</p>
                        </div>
                        <div>
                            <p class="font-medium">Фармацевт:</p>
                            <p class="text-gray-300">pharmacist@pharmacy.com / password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-8 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Pharmacy Management System. Курсова работа за ФМИ - Софийски университет.</p>
            <p class="mt-2 text-gray-400">Разработено с Laravel 10 и Tailwind CSS</p>
        </div>
    </footer>
</body>
</html>
