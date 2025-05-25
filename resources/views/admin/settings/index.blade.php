<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - CareerCON</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">System Settings</h1>
                
                <form class="space-y-6">
                    <!-- Site Settings -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Site Settings</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Site Name</label>
                                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="CareerCON">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contact Email</label>
                                <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="contact@careercon.com">
                            </div>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Email Settings</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">SMTP Host</label>
                                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="smtp.mailtrap.io">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">SMTP Port</label>
                                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="2525">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 