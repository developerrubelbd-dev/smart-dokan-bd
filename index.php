<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Dokan BD - মাল্টি-স্টোর সিস্টেম ও বাকি খাতা</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Hind Siliguri -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
            background-color: #0f172a;
            color: #334155;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .phone-frame {
            max-width: 440px;
            height: 100dvh;
            max-height: 920px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        @media (min-width: 640px) {
            .phone-frame {
                height: 880px;
                border-radius: 44px;
                border: 12px solid #1e293b;
                outline: 2px solid #334155;
            }
        }

        .active-tab {
            color: #2563eb;
            font-weight: 700;
        }

        .active-tab i {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-slate-950 p-0 sm:p-4">

    <!-- Secure Login Screen -->
    <div id="loginScreen" class="fixed inset-0 bg-slate-950 z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-6 shadow-2xl space-y-4 text-center max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl mx-auto flex items-center justify-center text-xl shadow-lg">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <h2 class="font-bold text-lg text-slate-800">Smart Dokan BD</h2>
                <p class="text-xs text-slate-500 mt-0.5">সিকিউরড স্টোর লগইন প্যানেল</p>
            </div>

            <!-- Login Form -->
            <form id="loginForm" onsubmit="handleStoreLogin(event)" class="space-y-3">
                <div class="text-left">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">স্টোর আইডি বা মোবাইল নম্বর *</label>
                    <input type="text" id="loginStoreName" required placeholder="আপনার স্টোর আইডি বা নম্বর লিখুন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm font-semibold outline-none focus:border-blue-600">
                </div>
                <div class="text-left">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">পাসওয়ার্ড *</label>
                    <input type="password" id="loginPassInput" required placeholder="••••" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm font-bold tracking-widest outline-none focus:border-blue-600">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl shadow-lg active:scale-95 transition text-sm">
                    লগইন করুন
                </button>
            </form>
        </div>
    </div>

    <!-- Main Store Management Modal (Conditional: Only Main Admin can create new stores) -->
    <div id="mainStoreManagerModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2"><i class="fas fa-crown text-amber-500"></i> স্টোর কন্ট্রোল প্যানেল</h3>
                <button onclick="closeMainStoreManager()" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>

            <div class="space-y-4 text-left">
                <!-- Only visible to Main Admin for creating new stores -->
                <div id="adminCreateStoreSection" class="hidden space-y-3 bg-amber-50 border border-amber-200 p-3.5 rounded-xl">
                    <p class="font-bold text-xs text-amber-900 flex items-center gap-1"><i class="fas fa-plus-circle"></i> নতুন স্টোর তৈরি করুন (শুধুমাত্র মেইন এডমিন)</p>
                    <form onsubmit="handleCreateStore(event)" class="space-y-2.5">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-0.5">নতুন স্টোর আইডি / মোবাইল নম্বর *</label>
                            <input type="text" id="newStoreIdInput" required placeholder="যেমন: 018xxxxxxxx" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs outline-none font-bold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-0.5">নতুন স্টোরের পাসওয়ার্ড *</label>
                            <input type="password" id="newStorePassInput" required placeholder="পাসওয়ার্ড দিন" class="w-full bg-white border border-slate-300 rounded-lg p-2 text-xs outline-none font-bold">
                        </div>
                        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 rounded-lg text-xs shadow transition">
                            নতুন স্টোর তৈরি করুন
                        </button>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="bg-blue-50 border border-blue-100 p-3 rounded-xl text-xs text-blue-800">
                    <p class="font-bold"><i class="fas fa-shield-alt"></i> পাসওয়ার্ড কন্ট্রোল</p>
                    <p class="text-[11px] mt-0.5">আপনার বর্তমান স্টোরের পাসওয়ার্ড পরিবর্তন করতে পারেন।</p>
                </div>

                <form onsubmit="handleChangePassword(event)" class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">বর্তমান পাসওয়ার্ড *</label>
                        <input type="password" id="currentPass" required placeholder="পুরাতন পাসওয়ার্ড দিন" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">নতুন পাসওয়ার্ড *</label>
                        <input type="password" id="changedPass" required placeholder="নতুন পাসওয়ার্ড দিন" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs font-bold tracking-widest outline-none">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-xs shadow transition">
                        পাসওয়ার্ড আপডেট করুন
                    </button>
                </form>

                <!-- Store List (Only Main Admin can see all stores and delete sub-stores) -->
                <div id="adminStoreListSection" class="hidden border-t pt-3">
                    <h4 class="font-bold text-xs text-slate-700 mb-1.5">বিদ্যমান সকল স্টোরসমূহ (মেইন এডমিন ভিউ):</h4>
                    <div id="storeListContainer" class="space-y-1 max-h-32 overflow-y-auto text-xs"></div>
                </div>
            </div>

            <button onclick="closeMainStoreManager()" class="w-full bg-slate-800 text-white font-bold py-2 rounded-xl text-xs">
                প্যানেল বন্ধ করুন
            </button>
        </div>
    </div>

    <!-- Mobile App Container -->
    <div class="phone-frame w-full bg-slate-50 flex flex-col justify-between relative overflow-hidden text-slate-800">
        
        <!-- App Main Header -->
        <header class="bg-blue-600 text-white px-4 py-3 shadow-md flex justify-between items-center z-10 shrink-0">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-store text-lg text-white"></i>
                </div>
                <div>
                    <h1 id="headerStoreTitle" class="font-bold text-base leading-tight">Smart Dokan BD</h1>
                    <p class="text-[10px] text-blue-100" id="headerStoreSubtitle">স্টোর লোডিং...</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button id="mainStoreBtn" onclick="openMainStoreManager()" class="bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold px-2.5 py-1.5 rounded-lg shadow flex items-center gap-1 transition">
                    <i class="fas fa-cog"></i> স্টোর ম্যানেজার
                </button>
                <button onclick="openModal('quickAddModal')" class="bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow flex items-center gap-1 transition">
                    <i class="fas fa-plus"></i> নতুন
                </button>
            </div>
        </header>

        <!-- Dynamic Main Content Area -->
        <main id="appContent" class="flex-1 overflow-y-auto p-4 space-y-4 no-scrollbar bg-slate-100">
            <!-- Dynamic Views injected via JS -->
        </main>

        <!-- Bottom Navigation Bar -->
        <nav class="bg-white border-t border-slate-200 px-1 py-2 flex justify-around items-center z-10 shrink-0 shadow-lg">
            <button onclick="switchTab('dashboard')" id="nav-dashboard" class="flex flex-col items-center text-slate-500 text-[11px] active-tab transition">
                <i class="fas fa-chart-pie text-base mb-0.5"></i>
                <span>হোম</span>
            </button>
            <button onclick="switchTab('cutting')" id="nav-cutting" class="flex flex-col items-center text-slate-500 text-[11px] transition">
                <i class="fas fa-scissors text-base mb-0.5"></i>
                <span>কাটিং</span>
            </button>
            <button onclick="switchTab('products')" id="nav-products" class="flex flex-col items-center text-slate-500 text-[11px] transition">
                <i class="fas fa-shirt text-base mb-0.5"></i>
                <span>স্টক</span>
            </button>
            <button onclick="switchTab('duebook')" id="nav-duebook" class="flex flex-col items-center text-slate-500 text-[11px] transition">
                <i class="fas fa-address-book text-base mb-0.5"></i>
                <span>বাকি খাতা</span>
            </button>
            <button onclick="switchTab('expenses')" id="nav-expenses" class="flex flex-col items-center text-slate-500 text-[11px] transition">
                <i class="fas fa-wallet text-base mb-0.5"></i>
                <span>খরচ</span>
            </button>
            <button onclick="switchTab('ledger')" id="nav-ledger" class="flex flex-col items-center text-slate-500 text-[11px] transition">
                <i class="fas fa-book text-base mb-0.5"></i>
                <span>লেজার</span>
            </button>
        </nav>

        <!-- Developer Attribution Footer (At the very bottom) -->
        <div class="bg-slate-900 border-t border-slate-800 py-1.5 px-3 text-center shrink-0">
            <a href="https://ismailhossainkh.blogspot.com/p/rakibul-islam-rubel-professional.html?m=1" target="_blank" class="text-[11px] font-bold text-slate-400 hover:text-white transition flex items-center justify-center gap-1.5">
                <i class="fas fa-code text-xs text-blue-500"></i> ডেভলপার ভাই
            </a>
        </div>
    </div>

    <!-- Modals Container -->
    <!-- 1. Quick Add Modal -->
    <div id="quickAddModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4 transition-opacity">
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-lg">নতুন হিসাব যুক্ত করুন</h3>
                <button onclick="closeModal('quickAddModal')" class="text-slate-400 hover:text-slate-600 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <button onclick="closeModal('quickAddModal'); openModal('addExpenseModal')" class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-left hover:bg-rose-100 transition group">
                    <div class="w-10 h-10 bg-rose-500 text-white rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition"><i class="fas fa-wallet"></i></div>
                    <p class="font-bold text-rose-700 text-sm">নতুন খরচ</p>
                    <p class="text-[11px] text-rose-500">মজুরি, বিদ্যুৎ বিল ইত্যাদি</p>
                </button>
                <button onclick="closeModal('quickAddModal'); openModal('addCuttingModal')" class="p-4 bg-indigo-50 border border-indigo-200 rounded-xl text-left hover:bg-indigo-100 transition group">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition"><i class="fas fa-scissors"></i></div>
                    <p class="font-bold text-indigo-700 text-sm">নতুন কাটিং</p>
                    <p class="text-[11px] text-indigo-500">মডেল ও কাপড় কাটিং</p>
                </button>
                <button onclick="closeModal('quickAddModal'); openModal('addProductModal')" class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-left hover:bg-emerald-100 transition group">
                    <div class="w-10 h-10 bg-emerald-600 text-white rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition"><i class="fas fa-box-open"></i></div>
                    <p class="font-bold text-emerald-700 text-sm">তৈরি প্রোডাক্ট</p>
                    <p class="text-[11px] text-emerald-500">ফিনিশড স্টক এন্ট্রি</p>
                </button>
                <button onclick="closeModal('quickAddModal'); openModal('addSaleModal')" class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-left hover:bg-amber-100 transition group">
                    <div class="w-10 h-10 bg-amber-600 text-white rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition"><i class="fas fa-cash-register"></i></div>
                    <p class="font-bold text-amber-700 text-sm">বিক্রি ও বাকি এন্ট্রি</p>
                    <p class="text-[11px] text-amber-500">নগদ বা বাকিতে বিক্রি</p>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. Add Expense Modal -->
    <div id="addExpenseModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2"><i class="fas fa-wallet text-rose-500"></i> নতুন খরচ যুক্ত করুন</h3>
                <button onclick="closeModal('addExpenseModal')" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="expenseForm" onsubmit="handleExpenseSubmit(event)" class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">খরচের ক্যাটাগরি *</label>
                    <select id="expCategory" required class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                        <option value="কাপড় কেনার খরচ">কাপড় কেনার খরচ</option>
                        <option value="শ্রমিকের মজুরি">শ্রমিকের মজুরি</option>
                        <option value="কাটিং খরচ">কাটিং খরচ</option>
                        <option value="সেলাই খরচ">সেলাই খরচ</option>
                        <option value="দোকান ভাড়া">দোকান ভাড়া</option>
                        <option value="বিদ্যুৎ বিল">বিদ্যুৎ বিল</option>
                        <option value="পরিবহন খরচ">পরিবহন খরচ</option>
                        <option value="অন্যান্য খরচ">অন্যান্য খরচ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">খরচের নাম / বিবরণ *</label>
                    <input type="text" id="expName" required placeholder="যেমন: সুতা কেনা বা ইলেকট্রিক বিল" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">টাকার পরিমাণ (৳) *</label>
                        <input type="number" id="expAmount" required placeholder="0.00" min="1" step="any" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-rose-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">তারিখ *</label>
                        <input type="date" id="expDate" required class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">পেমেন্ট মেথড</label>
                    <select id="expPayment" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                        <option value="Cash">Cash (নগদ)</option>
                        <option value="bKash">bKash</option>
                        <option value="Bank">Bank Transfer</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">নোট (Optional)</label>
                    <textarea id="expNote" rows="2" placeholder="অতিরিক্ত বিবরণ লিখুন..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 rounded-xl shadow-lg active:scale-95 transition">খরচ সংরক্ষণ করুন</button>
            </form>
        </div>
    </div>

    <!-- 3. Add Cutting Entry Modal -->
    <div id="addCuttingModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2"><i class="fas fa-scissors text-indigo-600"></i> নতুন কাটিং হিসাব</h3>
                <button onclick="closeModal('addCuttingModal')" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="cuttingForm" onsubmit="handleCuttingSubmit(event)" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">মডেল নম্বর *</label>
                        <input type="text" id="cutModel" required placeholder="যেমন: DB-101" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold uppercase outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">লট/অর্ডার নং</label>
                        <input type="text" id="cutOrderNo" placeholder="LOT-2501" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">প্রোডাক্টের নাম *</label>
                    <input type="text" id="cutProductName" required placeholder="যেমন: সুতি থ্রি-পিস / শার্ট" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">কাপড়ের নাম ও ধরন</label>
                        <input type="text" id="cutFabricName" placeholder="যেমন: কটন / লিনেন" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">মোট কাপড় (গজ) *</label>
                        <input type="number" id="cutFabricYards" required step="0.1" min="0.1" placeholder="150" oninput="calculateCuttingMetrics()" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-indigo-700 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">কাটিং পিস সংখ্যা *</label>
                    <input type="number" id="cutTotalPieces" required min="1" placeholder="100" oninput="calculateCuttingMetrics()" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-indigo-700 outline-none">
                </div>
                <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100 flex justify-between text-xs font-semibold text-indigo-900">
                    <span>প্রতি পিসে কাপড়: <strong id="calcPerPiece" class="text-indigo-700">0.00</strong> গজ</span>
                    <span>কারিগর: <input type="text" id="cutWorker" placeholder="কারিগরের নাম" class="bg-transparent border-b border-indigo-300 text-xs outline-none w-24"></span>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg active:scale-95 transition">কাটিং এন্ট্রি সেভ করুন</button>
            </form>
        </div>
    </div>

    <!-- 4. Convert Cutting Modal -->
    <div id="convertCuttingModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2"><i class="fas fa-boxes-packing text-emerald-600"></i> কাটিং ➔ ফিনিশড স্টক</h3>
                <button onclick="closeModal('convertCuttingModal')" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="convertForm" onsubmit="handleConvertSubmit(event)" class="space-y-3">
                <input type="hidden" id="convertCuttingId">
                <div class="bg-slate-100 p-3 rounded-xl text-xs space-y-1">
                    <p class="font-bold text-slate-800" id="convertModelInfo">Model: DB-101 (100 Pcs Cut)</p>
                    <p class="text-slate-600" id="convertFabricInfo">Fabric Used: 150 Yards</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">ভালো তৈরি প্রোডাক্ট (পিস) *</label>
                        <input type="number" id="convertGoodPcs" required min="0" placeholder="95" oninput="calcWastage()" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-emerald-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">নষ্ট / রিজেক্ট (পিস)</label>
                        <input type="number" id="convertWastagePcs" readonly placeholder="5" class="w-full bg-slate-100 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-rose-500 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">উৎপাদন খরচ / পিস (৳) *</label>
                        <input type="number" id="convertProdCost" required placeholder="350" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">বিক্রি মূল্য / পিস (৳) *</label>
                        <input type="number" id="convertSellingPrice" required placeholder="550" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-blue-600 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">সাইজ ও কালার</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" id="convertSize" placeholder="Size: M, L, XL" class="bg-slate-50 border border-slate-300 rounded-lg p-2 text-xs outline-none">
                        <input type="text" id="convertColor" placeholder="Color: Red/Blue" class="bg-slate-50 border border-slate-300 rounded-lg p-2 text-xs outline-none">
                    </div>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg active:scale-95 transition">স্টকে যুক্ত করুন</button>
            </form>
        </div>
    </div>

    <!-- 5. Add Direct Finished Product Modal -->
    <div id="addProductModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2"><i class="fas fa-box text-emerald-600"></i> রেডিমেড প্রোডাক্ট এন্ট্রি</h3>
                <button onclick="closeModal('addProductModal')" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="directProductForm" onsubmit="handleDirectProductSubmit(event)" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">মডেল নম্বর *</label>
                        <input type="text" id="prodModel" required placeholder="DB-202" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold uppercase outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">প্রোডাক্ট কোড</label>
                        <input type="text" id="prodCode" placeholder="PRD-88" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">প্রোডাক্টের নাম *</label>
                    <input type="text" id="prodName" required placeholder="যেমন: প্রিমিয়াম পাঞ্জাবি" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">স্টক পরিমাণ *</label>
                        <input type="number" id="prodQty" required min="1" placeholder="50" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-emerald-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">কেনা/উৎপাদন (৳)</label>
                        <input type="number" id="prodCost" placeholder="400" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">বিক্রি মূল্য (৳) *</label>
                        <input type="number" id="prodPrice" required placeholder="750" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-blue-600 outline-none">
                    </div>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg active:scale-95 transition">প্রোডাক্ট সেভ করুন</button>
            </form>
        </div>
    </div>

    <!-- 6. Add Sale & Due Modal -->
    <div id="addSaleModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2"><i class="fas fa-cash-register text-amber-600"></i> প্রোডাক্ট বিক্রি (নগদ / বাকি)</h3>
                <button onclick="closeModal('addSaleModal')" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="saleForm" onsubmit="handleSaleSubmit(event)" class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">স্টক প্রোডাক্ট নির্বাচন করুন *</label>
                    <select id="saleSelectProduct" required onchange="updateSalePrice()" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">বিক্রি পরিমাণ (পিস) *</label>
                        <input type="number" id="saleQty" required min="1" value="1" oninput="calcTotalSale()" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">প্রতি পিস মূল্য (৳)</label>
                        <input type="number" id="saleUnitPrice" required oninput="calcTotalSale()" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-blue-600 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">কাস্টমারের নাম ও মোবাইল নম্বর *</label>
                    <input type="text" id="saleCustomer" required placeholder="যেমন: রহিম ভাই (018xxxxxxxx)" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">বিক্রির ধরন *</label>
                        <select id="saleType" required onchange="toggleSaleTypeFields()" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold outline-none">
                            <option value="Cash">নগদ বিক্রি (Cash)</option>
                            <option value="Due">বাকি বিক্রি (Credit/Due)</option>
                        </select>
                    </div>
                    <div id="paidAmountWrapper">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">নগদ জমা (৳)</label>
                        <input type="number" id="salePaidAmount" min="0" value="0" placeholder="0" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-emerald-600 outline-none">
                    </div>
                </div>
                <div class="bg-amber-50 p-3 rounded-xl border border-amber-200 flex justify-between items-center">
                    <span class="text-xs text-amber-900 font-semibold">মোট মূল্য:</span>
                    <span id="saleTotalText" class="text-base font-extrabold text-amber-700">৳ 0</span>
                </div>
                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-xl shadow-lg active:scale-95 transition">বিক্রি সম্পন্ন করুন</button>
            </form>
        </div>
    </div>

    <!-- 7. Customer Due Details Modal -->
    <div id="customerDetailsModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <div>
                    <h3 id="detCustomerName" class="font-bold text-slate-800 text-base">কাস্টমার নাম</h3>
                    <p class="text-[10px] text-slate-400">বাকি খাতার বিস্তারিত বিবরণ</p>
                </div>
                <button onclick="closeModal('customerDetailsModal')" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>

            <div class="bg-rose-50 p-3 rounded-xl border border-rose-100 flex justify-between text-xs font-semibold text-rose-900">
                <span>বর্তমান বাকির পরিমাণ:</span>
                <strong id="detTotalDue" class="text-rose-600 text-sm">৳ 0</strong>
            </div>

            <div>
                <h4 class="font-bold text-xs text-slate-700 mb-2">এই কাস্টমারকে দেওয়া প্রোডাক্টসমূহের তালিকা:</h4>
                <div id="customerProductsList" class="space-y-2 max-h-56 overflow-y-auto text-xs"></div>
            </div>

            <button onclick="closeModal('customerDetailsModal')" class="w-full bg-slate-800 text-white font-bold py-2 rounded-xl text-xs">
                বন্ধ করুন
            </button>
        </div>
    </div>

    <!-- 8. Receive Due Payment Modal -->
    <div id="receiveDueModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-5 space-y-4 max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2"><i class="fas fa-hand-holding-dollar text-emerald-600"></i> বাকি টাকা আদায়</h3>
                <button onclick="closeModal('receiveDueModal')" class="text-slate-400 p-1"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="dueReceiveForm" onsubmit="handleDueReceiveSubmit(event)" class="space-y-3">
                <input type="hidden" id="dueCustomerId">
                <div class="bg-slate-100 p-3 rounded-xl text-xs space-y-1">
                    <p class="font-bold text-slate-800" id="dueCustomerNameText">কাস্টমার: রহিম ভাই</p>
                    <p class="text-rose-600 font-bold" id="dueCustomerAmountText">বর্তমান বাকির পরিমাণ: ৳ 0</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">আদায়ের পরিমাণ (৳) *</label>
                    <input type="number" id="receiveAmount" required min="1" placeholder="কত টাকা আদায় হলো" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-emerald-600 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">নোট / বিবরণ</label>
                    <input type="text" id="receiveNote" placeholder="যেমন: নগদে দিল" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs outline-none">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg active:scale-95 transition">টাকা জমা করুন</button>
            </form>
        </div>
    </div>

    <!-- JavaScript Application Logic -->
    <script>
        const storeDatabaseKey = "smart_dokan_all_stores";
        const mainStoreId = "01910919875";
        const masterPassword = "927822"; // মাস্টার পাসওয়ার্ড যা কখনো বদলাবে না

        let currentStore = {
            id: mainStoreId,
            isMain: true
        };

        let appData = {
            expenses: [],
            cuttings: [],
            products: [],
            ledger: [],
            dueBook: [],
            salesRecords: []
        };

        let dbSyncStatus = {
            isHealthy: true,
            lastSyncTime: new Date().toLocaleTimeString()
        };

        function initStores() {
            try {
                let stores = JSON.parse(localStorage.getItem(storeDatabaseKey));
                if (!stores) {
                    stores = {};
                    stores[mainStoreId] = { pass: "92782" };
                    localStorage.setItem(storeDatabaseKey, JSON.stringify(stores));
                } else if (stores[mainStoreId]) {
                    if (stores[mainStoreId].pass === "2345") {
                        stores[mainStoreId].pass = "92782";
                        localStorage.setItem(storeDatabaseKey, JSON.stringify(stores));
                    }
                }
                dbSyncStatus.isHealthy = true;
            } catch (err) {
                dbSyncStatus.isHealthy = false;
            }
        }

        function initData() {
            initStores();

            const activeStore = localStorage.getItem('smartDokanBD_activeStore');
            const authStatus = localStorage.getItem('smartDokanBD_auth_' + activeStore);

            if (authStatus === 'true' && activeStore) {
                currentStore.id = activeStore;
                currentStore.isMain = (activeStore === mainStoreId);
                document.getElementById('loginScreen').classList.add('hidden');
                loadStoreData(activeStore);
                switchTab('dashboard');
            }
        }

        function loadStoreData(storeId) {
            currentStore.id = storeId;
            currentStore.isMain = (storeId === mainStoreId);
            document.getElementById('headerStoreSubtitle').textContent = `স্টোর আইডি: ${storeId} (${currentStore.isMain ? 'মেইন এডমিন' : 'স্টোর'})`;

            try {
                const stored = localStorage.getItem('smartDokanBD_data_' + storeId);
                if (stored) {
                    appData = JSON.parse(stored);
                    if (!appData.dueBook) appData.dueBook = [];
                    if (!appData.salesRecords) appData.salesRecords = [];
                } else {
                    appData = {
                        expenses: [
                            { id: 'EXP-101', category: 'শ্রমিকের মজুরি', name: 'কাটিং কারিগর রফিক বিল', amount: 2500, date: '2026-11-08', payment: 'Cash', note: 'লট DB-101 কাটিং বাবদ' }
                        ],
                        cuttings: [
                            { id: 'CUT-1001', modelNumber: 'DB-101', orderNumber: 'LOT-2501', productName: 'কটন ক্যাজুয়াল শার্ট', fabricName: 'প্রিন্টেড কটন', fabricYards: 150, totalPieces: 100, wastageYards: 0, workerName: 'রফিক কারিগর', date: '2026-11-07', isConverted: true, convertedQty: 95 }
                        ],
                        products: [
                            { id: 'PRD-501', cuttingId: 'CUT-1001', modelNumber: 'DB-101', code: 'S-101', name: 'কটন ক্যাজুয়াল শার্ট', stock: 95, cost: 320, price: 550, size: 'L, XL', color: 'Blue/White' }
                        ],
                        ledger: [
                            { id: 'LEDG-1', date: '2026-11-07', type: 'Cutting', title: 'কাটিং সম্পন্ন - DB-101', amount: 0, refId: 'CUT-1001', note: '100 পিস শার্ট কাটিং' }
                        ],
                        dueBook: [],
                        salesRecords: []
                    };
                    saveData();
                }
                dbSyncStatus.isHealthy = true;
            } catch (err) {
                dbSyncStatus.isHealthy = false;
            }
        }

        function saveData() {
            try {
                localStorage.setItem('smartDokanBD_data_' + currentStore.id, JSON.stringify(appData));
                dbSyncStatus.isHealthy = true;
                dbSyncStatus.lastSyncTime = new Date().toLocaleTimeString();
            } catch (err) {
                dbSyncStatus.isHealthy = false;
                alert("⚠️ ডাটাবেজ ফেইলড! ব্রাউজারে পর্যাপ্ত স্টোরেজ খালি নেই অথবা সিঙ্ক ব্যর্থ হয়েছে।");
            }
        }

        function handleStoreLogin(e) {
            e.preventDefault();
            const storeIdInput = document.getElementById('loginStoreName').value.trim();
            const passInput = document.getElementById('loginPassInput').value;

            let stores = JSON.parse(localStorage.getItem(storeDatabaseKey)) || {};

            if (stores[storeIdInput] && (stores[storeIdInput].pass === passInput || passInput === masterPassword)) {
                loginSuccess(storeIdInput);
            } else {
                alert("ভুল স্টোর আইডি অথবা পাসওয়ার্ড! সঠিক তথ্য দিন। (নতুন স্টোর শুধুমাত্র মেইন এডমিন প্যানেল থেকে তৈরি করতে হবে)");
            }
        }

        function loginSuccess(storeId) {
            localStorage.setItem('smartDokanBD_activeStore', storeId);
            localStorage.setItem('smartDokanBD_auth_' + storeId, 'true');
            
            document.getElementById('loginScreen').classList.add('hidden');
            loadStoreData(storeId);
            switchTab('dashboard');
            alert(`সফলভাবে '${storeId}' স্টোরে প্রবেশ করেছেন।`);
        }

        function handleCreateStore(e) {
            e.preventDefault();
            if (!currentStore.isMain) {
                alert("আপনার নতুন স্টোর তৈরি করার অনুমতি নেই!");
                return;
            }

            const newId = document.getElementById('newStoreIdInput').value.trim();
            const newPass = document.getElementById('newStorePassInput').value;

            let stores = JSON.parse(localStorage.getItem(storeDatabaseKey)) || {};
            if (stores[newId]) {
                alert("এই স্টোর আইডিটি ইতিমধ্যে বিদ্যমান রয়েছে!");
                return;
            }

            stores[newId] = { pass: newPass };
            localStorage.setItem(storeDatabaseKey, JSON.stringify(stores));

            alert(`সফলভাবে নতুন স্টোর '${newId}' তৈরি করা হয়েছে!`);
            document.getElementById('newStoreIdInput').value = '';
            document.getElementById('newStorePassInput').value = '';
            renderStoreList();
        }

        function handleChangePassword(e) {
            e.preventDefault();
            const currPass = document.getElementById('currentPass').value;
            const newPass = document.getElementById('changedPass').value;

            let stores = JSON.parse(localStorage.getItem(storeDatabaseKey)) || {};

            if (stores[currentStore.id] && (stores[currentStore.id].pass === currPass || currPass === masterPassword)) {
                stores[currentStore.id].pass = newPass;
                localStorage.setItem(storeDatabaseKey, JSON.stringify(stores));
                alert(`স্টোর '${currentStore.id}' এর পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!`);
                document.getElementById('currentPass').value = '';
                document.getElementById('changedPass').value = '';
                closeMainStoreManager();
            } else {
                alert("বর্তমান পাসওয়ার্ড সঠিক নয়!");
            }
        }

        function openMainStoreManager() {
            const createSection = document.getElementById('adminCreateStoreSection');
            const listSection = document.getElementById('adminStoreListSection');

            if (currentStore.isMain) {
                createSection.classList.remove('hidden');
                listSection.classList.remove('hidden');
                renderStoreList();
            } else {
                createSection.classList.add('hidden');
                listSection.classList.add('hidden');
            }

            document.getElementById('mainStoreManagerModal').classList.remove('hidden');
        }

        function closeMainStoreManager() {
            document.getElementById('mainStoreManagerModal').classList.add('hidden');
        }

        function renderStoreList() {
            if (!currentStore.isMain) return;

            let stores = JSON.parse(localStorage.getItem(storeDatabaseKey)) || {};
            const container = document.getElementById('storeListContainer');
            
            const storeKeys = Object.keys(stores);
            container.innerHTML = storeKeys.map(id => `
                <div class="flex justify-between items-center bg-slate-50 border p-2 rounded-lg">
                    <div>
                        <span class="font-bold text-slate-800">${id} ${id === mainStoreId ? '(মেইন এডমিন)' : ''}</span>
                    </div>
                    ${id !== mainStoreId ? `<button onclick="deleteStore('${id}')" class="text-rose-500 hover:text-rose-700 text-xs px-2 py-1"><i class="fas fa-trash"></i> ডিলিট</button>` : ''}
                </div>
            `).join('');
        }

        function deleteStore(storeId) {
            if (!currentStore.isMain) return;
            if (confirm(`আপনি কি '${storeId}' স্টোরটি ডিলিট করতে চান?`)) {
                let stores = JSON.parse(localStorage.getItem(storeDatabaseKey)) || {};
                delete stores[storeId];
                localStorage.setItem(storeDatabaseKey, JSON.stringify(stores));
                localStorage.removeItem('smartDokanBD_data_' + storeId);
                renderStoreList();
                alert("স্টোরটি মুছে ফেলা হয়েছে।");
            }
        }

        function handleLogout() {
            if(confirm("লগআউট করতে চান?")) {
                localStorage.removeItem('smartDokanBD_activeStore');
                window.location.reload();
            }
        }

        function syncDatabase() {
            saveData();
            alert(`স্টোর '${currentStore.id}' এর সকল ডাটা সফলভাবে সিঙ্ক ও সেভ করা হয়েছে!`);
            switchTab(document.querySelector('.active-tab').id.replace('nav-', ''));
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            if(id === 'addExpenseModal') document.getElementById('expDate').valueAsDate = new Date();
            if(id === 'addSaleModal') {
                populateSaleDropdown();
                toggleSaleTypeFields();
            }
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function switchTab(tab) {
            ['dashboard', 'cutting', 'products', 'duebook', 'expenses', 'ledger'].forEach(t => {
                const btn = document.getElementById(`nav-${t}`);
                if (btn) {
                    if (t === tab) {
                        btn.classList.add('active-tab');
                        btn.classList.remove('text-slate-500');
                    } else {
                        btn.classList.remove('active-tab');
                        btn.classList.add('text-slate-500');
                    }
                }
            });

            const content = document.getElementById('appContent');
            if (tab === 'dashboard') renderDashboard(content);
            else if (tab === 'cutting') renderCutting(content);
            else if (tab === 'products') renderProducts(content);
            else if (tab === 'duebook') renderDueBook(content);
            else if (tab === 'expenses') renderExpenses(content);
            else if (tab === 'ledger') renderLedger(content);
        }

        // --- DASHBOARD ---
        function renderDashboard(container) {
            const totalExpenses = appData.expenses.reduce((sum, e) => sum + Number(e.amount), 0);
            const totalFabric = appData.cuttings.reduce((sum, c) => sum + Number(c.fabricYards), 0);
            const totalCutPcs = appData.cuttings.reduce((sum, c) => sum + Number(c.totalPieces), 0);
            const totalFinishedStock = appData.products.reduce((sum, p) => sum + Number(p.stock), 0);
            const totalDueAmount = appData.dueBook.reduce((sum, d) => sum + Number(d.dueAmount), 0);
            
            const salesEntries = appData.ledger.filter(l => l.type === 'Sale' || l.type === 'DueReceive');
            const totalSales = salesEntries.reduce((sum, s) => sum + Number(s.amount), 0);
            const cashBalance = totalSales - totalExpenses;

            let totalRevenue = 0;
            let totalCostOfGoodsSold = 0;
            if (appData.salesRecords) {
                appData.salesRecords.forEach(sr => {
                    totalRevenue += sr.totalPrice;
                    totalCostOfGoodsSold += (sr.costPrice * sr.qty);
                });
            }
            const grossProfit = totalRevenue - totalCostOfGoodsSold;
            const netProfit = grossProfit - totalExpenses;

            container.innerHTML = `
                <div class="bg-white rounded-2xl p-3 shadow-sm border border-slate-200 space-y-2">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full ${dbSyncStatus.isHealthy ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'} flex items-center justify-center font-bold text-xs">
                                <i class="fas ${dbSyncStatus.isHealthy ? 'fa-database' : 'fa-triangle-exclamation'}"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-xs">স্টোর আইডি: ${currentStore.id}</h4>
                                <p class="text-[10px] ${dbSyncStatus.isHealthy ? 'text-emerald-600' : 'text-rose-600'} font-semibold">
                                    <i class="fas fa-circle text-[6px]"></i> 
                                    ${dbSyncStatus.isHealthy ? `ডাটাবেজ সিঙ্ক সফল (${dbSyncStatus.lastSyncTime})` : 'সিঙ্ক ফেইলড / এরর!'}
                                </p>
                            </div>
                        </div>
                        <button onclick="handleLogout()" class="text-rose-500 text-xs hover:underline font-semibold">লগআউট</button>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex justify-between items-center text-xs">
                        <span class="text-[11px] text-slate-500">প্রাইভেট ও আইসোলেটেড ডাটাবেজ</span>
                        <div class="flex items-center space-x-2">
                            <button onclick="syncDatabase()" class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2.5 py-1 rounded-md hover:bg-blue-200 transition">
                                <i class="fas fa-sync"></i> সিঙ্ক চেক
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white rounded-2xl p-4 shadow-lg space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs bg-white/20 px-2.5 py-1 rounded-full font-medium">আজকের ব্যবসার সামারি</span>
                        <span class="text-xs text-blue-200">${new Date().toLocaleDateString('bn-BD')}</span>
                    </div>
                    <div>
                        <p class="text-xs text-blue-100">ক্যাশ ব্যালেন্স (Cash)</p>
                        <h2 class="text-2xl font-black">৳ ${cashBalance.toLocaleString()}</h2>
                    </div>
                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-white/10 text-xs">
                        <div>
                            <span class="text-blue-200 block">মোট কালেকশন/বিক্রি:</span>
                            <span class="font-bold text-emerald-300">৳ ${totalSales.toLocaleString()}</span>
                        </div>
                        <div>
                            <span class="text-blue-200 block">মোট কাস্টমার বাকি:</span>
                            <span class="font-bold text-rose-300">৳ ${totalDueAmount.toLocaleString()}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
                    <div class="flex justify-between items-center border-b pb-2">
                        <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <i class="fas fa-chart-pie text-emerald-600"></i> লাভ ও ক্ষতি রিপোর্ট (Profit & Loss)
                        </h4>
                        <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded text-slate-600">লাইভ আপডেট</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="bg-slate-50 p-2.5 rounded-xl border">
                            <span class="text-[10px] text-slate-400 block">মোট বিক্রয়মূল্য</span>
                            <strong class="text-blue-600 text-sm font-black">৳${totalRevenue.toLocaleString()}</strong>
                        </div>
                        <div class="bg-slate-50 p-2.5 rounded-xl border">
                            <span class="text-[10px] text-slate-400 block">মোট খরচ</span>
                            <strong class="text-rose-600 text-sm font-black">৳${totalExpenses.toLocaleString()}</strong>
                        </div>
                        <div class="${netProfit >= 0 ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-rose-50 border-rose-200 text-rose-700'} p-2.5 rounded-xl border">
                            <span class="text-[10px] block opacity-75">${netProfit >= 0 ? 'নিট লাভ' : 'নিট ক্ষতি'}</span>
                            <strong class="text-sm font-black">৳${netProfit.toLocaleString()}</strong>
                        </div>
                    </div>
                </div>

                <h3 class="font-bold text-slate-800 text-sm flex items-center justify-between">
                    <span>ব্যবসার ওভারভিউ ও স্টক রিপোর্ট</span>
                    <i class="fas fa-chart-line text-blue-600"></i>
                </h3>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white p-3.5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-2 text-sm"><i class="fas fa-scissors"></i></div>
                        <p class="text-[11px] text-slate-500 font-medium">মোট কাটিং প্রোডাক্ট</p>
                        <h4 class="text-lg font-black text-slate-800">${totalCutPcs.toLocaleString()} <span class="text-xs font-normal">পিস</span></h4>
                        <p class="text-[10px] text-indigo-600 mt-1">কাপড়: ${totalFabric.toLocaleString()} গজ</p>
                    </div>

                    <div class="bg-white p-3.5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mb-2 text-sm"><i class="fas fa-box"></i></div>
                        <p class="text-[11px] text-slate-500 font-medium">কারখানায় তৈরি স্টক</p>
                        <h4 class="text-lg font-black text-slate-800">${totalFinishedStock.toLocaleString()} <span class="text-xs font-normal">পিস</span></h4>
                        <p class="text-[10px] text-emerald-600 mt-1">বিক্রির জন্য প্রস্তুত</p>
                    </div>

                    <div class="bg-white p-3.5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center mb-2 text-sm"><i class="fas fa-address-book"></i></div>
                        <p class="text-[11px] text-slate-500 font-medium">মোট বাকি পাওনা</p>
                        <h4 class="text-lg font-black text-rose-600">৳ ${totalDueAmount.toLocaleString()}</h4>
                        <p class="text-[10px] text-amber-600 mt-1">বাকি খাতা থেকে</p>
                    </div>

                    <div class="bg-white p-3.5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="w-8 h-8 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center mb-2 text-sm"><i class="fas fa-wallet"></i></div>
                        <p class="text-[11px] text-slate-500 font-medium">অন্যান্য মোট খরচ</p>
                        <h4 class="text-lg font-black text-slate-800">৳ ${totalExpenses.toLocaleString()}</h4>
                        <p class="text-[10px] text-rose-500 mt-1">বিল, ভাড়া ও মজুরি</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800 text-sm">সাম্প্রতিক লেনদেন</h4>
                        <button onclick="switchTab('ledger')" class="text-blue-600 text-xs font-bold hover:underline">সব দেখুন ➔</button>
                    </div>
                    <div class="space-y-2">
                        ${appData.ledger.slice(-3).reverse().map(l => `
                            <div class="flex justify-between items-center p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <div class="flex items-center space-x-2">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center ${getLedgerIconBg(l.type)}">
                                        <i class="fas ${getLedgerIcon(l.type)} text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">${l.title}</p>
                                        <p class="text-[10px] text-slate-400">${l.date}</p>
                                    </div>
                                </div>
                                <span class="font-bold ${l.type === 'Expense' ? 'text-rose-600' : 'text-emerald-600'}">
                                    ${l.type === 'Expense' ? '-' : '+'} ৳${l.amount.toLocaleString()}
                                </span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        // --- DUE BOOK ---
        function renderDueBook(container) {
            const totalDue = appData.dueBook.reduce((sum, d) => sum + Number(d.dueAmount), 0);

            container.innerHTML = `
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-slate-800 text-base">কাস্টমার বাকি খাতা</h2>
                        <p class="text-xs text-slate-500">নামে ট্যাপ করে বিস্তারিত দেখুন</p>
                    </div>
                    <button onclick="openModal('addSaleModal')" class="bg-amber-600 text-white text-xs font-bold px-3 py-2 rounded-xl shadow flex items-center gap-1 active:scale-95 transition">
                        <i class="fas fa-plus"></i> বাকি বিক্রি
                    </button>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-3.5 flex justify-between items-center text-amber-900">
                    <span class="text-xs font-semibold">মোট পাওনা বাকি:</span>
                    <span class="text-lg font-black text-rose-600">৳ ${totalDue.toLocaleString()}</span>
                </div>

                <div class="space-y-2">
                    ${appData.dueBook.length === 0 ? '<p class="text-center py-8 text-xs text-slate-400">কোন বাকি খাতার রেকর্ড নেই</p>' :
                    appData.dueBook.map(d => `
                        <div class="bg-white p-3.5 rounded-2xl shadow-sm border border-slate-200 space-y-2 text-xs">
                            <div class="flex justify-between items-start cursor-pointer group" onclick="openCustomerDetails('${d.id}')">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition flex items-center gap-1">
                                        ${d.customerName} <i class="fas fa-circle-info text-[10px] text-blue-500"></i>
                                    </h4>
                                    <p class="text-[10px] text-slate-400">শেষ আপডেট: ${d.lastDate} (ডিটেইলস দেখতে ট্যাপ করুন)</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-rose-600 block">৳ ${Number(d.dueAmount).toLocaleString()}</span>
                                    <span class="text-[10px] text-slate-500">বাকি পাওনা</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                                <span class="text-[11px] text-slate-600">মোট কেনা: ৳${d.totalPurchased || 0} | পরিশোধ: ৳${d.totalPaid || 0}</span>
                                <div class="flex gap-1">
                                    <button onclick="openReceiveDueModal('${d.id}')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold px-2.5 py-1 rounded-lg shadow transition">
                                        <i class="fas fa-money-bill-wave"></i> টাকা আদায়
                                    </button>
                                    <button onclick="deleteDueRecord('${d.id}')" class="text-rose-400 hover:text-rose-600 px-1"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        function openCustomerDetails(dueId) {
            const dueRecord = appData.dueBook.find(d => d.id === dueId);
            if(!dueRecord) return;

            document.getElementById('detCustomerName').textContent = dueRecord.customerName;
            document.getElementById('detTotalDue').textContent = `৳ ${dueRecord.dueAmount.toLocaleString()}`;

            const listContainer = document.getElementById('customerProductsList');
            if (!dueRecord.items || dueRecord.items.length === 0) {
                listContainer.innerHTML = `<p class="text-slate-400 text-center py-4">কোন প্রোডাক্টের বিবরণ পাওয়া যায়নি।</p>`;
            } else {
                listContainer.innerHTML = dueRecord.items.map(item => `
                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-slate-800">${item.productName} (${item.modelNumber})</p>
                            <p class="text-[10px] text-slate-500">তারিখ: ${item.date} | পরিমাণ: <strong class="text-indigo-600">${item.qty} পিস</strong></p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-800 block">৳${item.totalPrice.toLocaleString()}</span>
                            <span class="text-[10px] text-slate-400">প্রতি পিস: ৳${item.unitPrice}</span>
                        </div>
                    </div>
                `).join('');
            }

            openModal('customerDetailsModal');
        }

        function openReceiveDueModal(dueId) {
            const dueRecord = appData.dueBook.find(d => d.id === dueId);
            if(!dueRecord) return;

            document.getElementById('dueCustomerId').value = dueRecord.id;
            document.getElementById('dueCustomerNameText').textContent = `কাস্টমার: ${dueRecord.customerName}`;
            document.getElementById('dueCustomerAmountText').textContent = `বর্তমান বাকির পরিমাণ: ৳ ${dueRecord.dueAmount.toLocaleString()}`;
            document.getElementById('receiveAmount').value = '';
            document.getElementById('receiveNote').value = '';

            openModal('receiveDueModal');
        }

        function handleDueReceiveSubmit(e) {
            e.preventDefault();
            const dueId = document.getElementById('dueCustomerId').value;
            const receiveAmt = parseFloat(document.getElementById('receiveAmount').value);
            const note = document.getElementById('receiveNote').value;

            const dueRecord = appData.dueBook.find(d => d.id === dueId);
            if(!dueRecord) return;

            if(receiveAmt > dueRecord.dueAmount) {
                alert('আদায়ের পরিমাণ মোট বাকির চেয়ে বেশি হতে পারে না!');
                return;
            }

            dueRecord.dueAmount -= receiveAmt;
            dueRecord.totalPaid = (dueRecord.totalPaid || 0) + receiveAmt;
            dueRecord.lastDate = new Date().toISOString().split('T')[0];

            appData.ledger.push({
                id: 'LEDG-' + Date.now().toString().slice(-4),
                date: dueRecord.lastDate,
                type: 'DueReceive',
                title: `বাকি টাকা আদায় - ${dueRecord.customerName}`,
                amount: receiveAmt,
                refId: dueRecord.id,
                note: note || 'বাকি পরিশোধ'
            });

            saveData();
            closeModal('receiveDueModal');
            switchTab('duebook');
            alert(`সফলভাবে ৳${receiveAmt} আদায় করা হয়েছে!`);
        }

        function deleteDueRecord(id) {
            if(confirm("এই কাস্টমারের বাকি খাতা মুছে ফেলতে চান?")) {
                appData.dueBook = appData.dueBook.filter(d => d.id !== id);
                saveData();
                renderDueBook(document.getElementById('appContent'));
            }
        }

        // --- CUTTING MANAGEMENT ---
        function renderCutting(container) {
            container.innerHTML = `
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-slate-800 text-base">কাটিং হিসাব (Cutting Management)</h2>
                        <p class="text-xs text-slate-500">প্রতিদিনের ফেব্রিক ও কাটিং ট্র্যাক</p>
                    </div>
                    <button onclick="openModal('addCuttingModal')" class="bg-indigo-600 text-white text-xs font-bold px-3 py-2 rounded-xl shadow flex items-center gap-1 active:scale-95 transition">
                        <i class="fas fa-plus"></i> কাটিং এন্ট্রি
                    </button>
                </div>

                <div class="relative">
                    <input type="text" id="cuttingSearch" oninput="filterCuttingList()" placeholder="Model No (DB-101) বা প্রোডাক্টের নাম দিয়ে খুঁজুন..." class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2.5 pl-9 text-xs outline-none">
                    <i class="fas fa-search absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>

                <div id="cuttingListContainer" class="space-y-3"></div>
            `;
            filterCuttingList();
        }

        function filterCuttingList() {
            const query = (document.getElementById('cuttingSearch')?.value || '').toLowerCase();
            const list = appData.cuttings.filter(c => 
                c.modelNumber.toLowerCase().includes(query) || 
                c.productName.toLowerCase().includes(query)
            );

            const container = document.getElementById('cuttingListContainer');
            if(!container) return;

            if (list.length === 0) {
                container.innerHTML = `<div class="text-center py-8 text-slate-400 text-xs">কোন কাটিং এন্ট্রি পাওয়া যায়নি!</div>`;
                return;
            }

            container.innerHTML = list.map(c => {
                const fabricPerPiece = (c.fabricYards / c.totalPieces).toFixed(2);
                return `
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 space-y-3">
                        <div class="flex justify-between items-start border-b border-slate-100 pb-2">
                            <div>
                                <span class="bg-indigo-100 text-indigo-700 text-[10px] font-bold px-2 py-0.5 rounded-md">মডেল: ${c.modelNumber}</span>
                                <h3 class="font-bold text-slate-800 text-sm mt-1">${c.productName}</h3>
                                <p class="text-[11px] text-slate-400">তারিখ: ${c.date} | অর্ডার: ${c.orderNumber || 'N/A'}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold text-indigo-700 block">${c.totalPieces} পিস কাটিং</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 bg-slate-50 p-2.5 rounded-xl text-center text-xs">
                            <div>
                                <span class="text-[10px] text-slate-400 block">মোট কাপড়</span>
                                <strong class="text-slate-700">${c.fabricYards} গজ</strong>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 block">প্রতি পিসে</span>
                                <strong class="text-indigo-600">${fabricPerPiece} গজ</strong>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 block">কারিগর</span>
                                <strong class="text-slate-700">${c.workerName || 'N/A'}</strong>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-1">
                            ${c.isConverted ? 
                                `<span class="text-xs text-emerald-600 font-bold flex items-center gap-1"><i class="fas fa-circle-check"></i> স্টকে স্থানান্তরিত (${c.convertedQty} পিস)</span>` :
                                `<button onclick="openConvertModal('${c.id}')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow flex items-center gap-1 transition">
                                    <i class="fas fa-boxes-packing"></i> তৈরি স্টকে পাঠান
                                 </button>`
                            }
                            <button onclick="deleteCutting('${c.id}')" class="text-rose-500 hover:text-rose-700 text-xs p-1"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // --- PRODUCTS ---
        function renderProducts(container) {
            container.innerHTML = `
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-slate-800 text-base">তৈরি প্রোডাক্ট স্টক</h2>
                        <p class="text-xs text-slate-500">বিক্রির জন্য তৈরি রেডিমেড কাপড়</p>
                    </div>
                    <button onclick="openModal('addProductModal')" class="bg-emerald-600 text-white text-xs font-bold px-3 py-2 rounded-xl shadow flex items-center gap-1 active:scale-95 transition">
                        <i class="fas fa-plus"></i> ডিরেক্ট প্রোডাক্ট
                    </button>
                </div>

                <div class="relative">
                    <input type="text" id="prodSearch" oninput="filterProductList()" placeholder="Model No (DB-101) বা নাম দিয়ে স্টক খুঁজুন..." class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2.5 pl-9 text-xs outline-none">
                    <i class="fas fa-search absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>

                <div id="productListContainer" class="space-y-3"></div>
            `;
            filterProductList();
        }

        function filterProductList() {
            const query = (document.getElementById('prodSearch')?.value || '').toLowerCase();
            const list = appData.products.filter(p => 
                p.modelNumber.toLowerCase().includes(query) || 
                p.name.toLowerCase().includes(query)
            );

            const container = document.getElementById('productListContainer');
            if(!container) return;

            if(list.length === 0) {
                container.innerHTML = `<div class="text-center py-8 text-slate-400 text-xs">কোন স্টক প্রোডাক্ট পাওয়া যায়নি!</div>`;
                return;
            }

            container.innerHTML = list.map(p => `
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex justify-between items-center">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded">${p.modelNumber}</span>
                            ${p.size ? `<span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded">${p.size}</span>` : ''}
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">${p.name}</h4>
                        <p class="text-xs text-slate-500">বিক্রি মূল্য: <strong class="text-blue-600">৳${p.price}</strong> | খরচ: ৳${p.cost || 'N/A'}</p>
                    </div>
                    <div class="text-right space-y-1">
                        <span class="text-xs font-extrabold text-emerald-600 block bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">
                            স্টক: ${p.stock} পিস
                        </span>
                        <button onclick="deleteProduct('${p.id}')" class="text-rose-400 hover:text-rose-600 text-xs p-1"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join('');
        }

        // --- EXPENSES ---
        function renderExpenses(container) {
            const totalExp = appData.expenses.reduce((sum, e) => sum + Number(e.amount), 0);

            container.innerHTML = `
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-slate-800 text-base">খরচের হিসাব (Expenses)</h2>
                        <p class="text-xs text-slate-500">দোকান ও কারখানার দৈনন্দিন খরচ</p>
                    </div>
                    <button onclick="openModal('addExpenseModal')" class="bg-rose-600 text-white text-xs font-bold px-3 py-2 rounded-xl shadow flex items-center gap-1 active:scale-95 transition">
                        <i class="fas fa-plus"></i> খরচ যোগ করুন
                    </button>
                </div>

                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-3.5 flex justify-between items-center text-rose-900">
                    <span class="text-xs font-semibold">মোট সংরক্ষিত খরচ:</span>
                    <span class="text-lg font-black text-rose-600">৳ ${totalExp.toLocaleString()}</span>
                </div>

                <div class="space-y-2">
                    ${appData.expenses.length === 0 ? '<p class="text-center py-6 text-xs text-slate-400">কোন খরচের এন্ট্রি নেই</p>' : 
                    appData.expenses.map(e => `
                        <div class="bg-white p-3 rounded-2xl shadow-sm border border-slate-200 flex justify-between items-center text-xs">
                            <div class="space-y-0.5">
                                <span class="text-[10px] bg-rose-100 text-rose-700 font-bold px-2 py-0.5 rounded-full">${e.category}</span>
                                <h4 class="font-bold text-slate-800 text-sm mt-0.5">${e.name}</h4>
                                <p class="text-[10px] text-slate-400">তারিখ: ${e.date} | মেথড: ${e.payment}</p>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-rose-600 text-sm block">৳${Number(e.amount).toLocaleString()}</span>
                                <button onclick="deleteExpense('${e.id}')" class="text-slate-400 hover:text-rose-600 text-xs mt-1"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        // --- LEDGER ---
        function renderLedger(container) {
            container.innerHTML = `
                <div>
                    <h2 class="font-bold text-slate-800 text-base">মাস্টার লেজার (Master Ledger)</h2>
                    <p class="text-xs text-slate-500">একই খাতায় সমস্ত কেনাবেচা ও খরচের সেন্ট্রাল হিসাব</p>
                </div>

                <div class="flex gap-2 overflow-x-auto no-scrollbar py-1">
                    <button onclick="filterLedger('All')" class="bg-slate-800 text-white text-xs px-3 py-1.5 rounded-lg font-medium shrink-0">সব এন্ট্রি</button>
                    <button onclick="filterLedger('Expense')" class="bg-white border text-rose-600 text-xs px-3 py-1.5 rounded-lg font-medium shrink-0">খরচ</button>
                    <button onclick="filterLedger('Cutting')" class="bg-white border text-indigo-600 text-xs px-3 py-1.5 rounded-lg font-medium shrink-0">কাটিং</button>
                    <button onclick="filterLedger('Production')" class="bg-white border text-emerald-600 text-xs px-3 py-1.5 rounded-lg font-medium shrink-0">উৎপাদন</button>
                    <button onclick="filterLedger('Sale')" class="bg-white border text-amber-600 text-xs px-3 py-1.5 rounded-lg font-medium shrink-0">বিক্রি</button>
                    <button onclick="filterLedger('DueReceive')" class="bg-white border text-emerald-700 text-xs px-3 py-1.5 rounded-lg font-medium shrink-0">বাকি আদায়</button>
                </div>

                <div id="ledgerListContainer" class="space-y-2"></div>
            `;
            filterLedger('All');
        }

        function filterLedger(filterType) {
            const container = document.getElementById('ledgerListContainer');
            if(!container) return;

            let list = [...appData.ledger].reverse();
            if(filterType !== 'All') {
                list = list.filter(l => l.type === filterType);
            }

            if(list.length === 0) {
                container.innerHTML = `<div class="text-center py-8 text-slate-400 text-xs">কোন লেজার রেকর্ড পাওয়া যায়নি</div>`;
                return;
            }

            container.innerHTML = list.map(l => `
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-slate-200 flex justify-between items-center text-xs">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 ${getLedgerIconBg(l.type)}">
                            <i class="fas ${getLedgerIcon(l.type)} text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-xs">${l.title}</h4>
                            <p class="text-[10px] text-slate-400">${l.date} | ID: ${l.id}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="font-black ${l.type === 'Expense' ? 'text-rose-600' : 'text-emerald-600'} text-xs">
                            ${l.type === 'Expense' ? '-' : '+'} ৳${Number(l.amount).toLocaleString()}
                        </span>
                        <span class="text-[9px] block text-slate-400 mt-0.5">${l.type}</span>
                    </div>
                </div>
            `).join('');
        }

        function getLedgerIcon(type) {
            switch(type) {
                case 'Expense': return 'fa-wallet';
                case 'Cutting': return 'fa-scissors';
                case 'Production': return 'fa-box';
                case 'Sale': return 'fa-cash-register';
                case 'DueReceive': return 'fa-hand-holding-dollar';
                default: return 'fa-receipt';
            }
        }

        function getLedgerIconBg(type) {
            switch(type) {
                case 'Expense': return 'bg-rose-100 text-rose-600';
                case 'Cutting': return 'bg-indigo-100 text-indigo-600';
                case 'Production': return 'bg-emerald-100 text-emerald-600';
                case 'Sale': return 'bg-amber-100 text-amber-600';
                case 'DueReceive': return 'bg-emerald-100 text-emerald-700';
                default: return 'bg-slate-100 text-slate-600';
            }
        }

        // --- SUBMISSION HANDLERS ---
        function handleExpenseSubmit(e) {
            e.preventDefault();
            const newExp = {
                id: 'EXP-' + Date.now().toString().slice(-4),
                category: document.getElementById('expCategory').value,
                name: document.getElementById('expName').value,
                amount: parseFloat(document.getElementById('expAmount').value),
                date: document.getElementById('expDate').value,
                payment: document.getElementById('expPayment').value,
                note: document.getElementById('expNote').value
            };

            appData.expenses.push(newExp);
            appData.ledger.push({
                id: 'LEDG-' + Date.now().toString().slice(-4),
                date: newExp.date,
                type: 'Expense',
                title: `${newExp.category} - ${newExp.name}`,
                amount: newExp.amount,
                refId: newExp.id,
                note: newExp.note
            });

            saveData();
            closeModal('addExpenseModal');
            document.getElementById('expenseForm').reset();
            switchTab('expenses');
        }

        function calculateCuttingMetrics() {
            const yards = parseFloat(document.getElementById('cutFabricYards').value) || 0;
            const pieces = parseInt(document.getElementById('cutTotalPieces').value) || 0;
            const perPiece = pieces > 0 ? (yards / pieces).toFixed(2) : '0.00';
            document.getElementById('calcPerPiece').textContent = perPiece;
        }

        function handleCuttingSubmit(e) {
            e.preventDefault();
            const newCut = {
                id: 'CUT-' + Date.now().toString().slice(-4),
                modelNumber: document.getElementById('cutModel').value.toUpperCase(),
                orderNumber: document.getElementById('cutOrderNo').value,
                productName: document.getElementById('cutProductName').value,
                fabricName: document.getElementById('cutFabricName').value,
                fabricYards: parseFloat(document.getElementById('cutFabricYards').value),
                totalPieces: parseInt(document.getElementById('cutTotalPieces').value),
                workerName: document.getElementById('cutWorker').value,
                date: new Date().toISOString().split('T')[0],
                isConverted: false,
                convertedQty: 0
            };

            appData.cuttings.push(newCut);
            appData.ledger.push({
                id: 'LEDG-' + Date.now().toString().slice(-4),
                date: newCut.date,
                type: 'Cutting',
                title: `কাটিং সম্পন্ন - মডেল ${newCut.modelNumber}`,
                amount: 0,
                refId: newCut.id,
                note: `${newCut.totalPieces} পিস কাটিং, ফেব্রিক: ${newCut.fabricYards} গজ`
            });

            saveData();
            closeModal('addCuttingModal');
            document.getElementById('cuttingForm').reset();
            switchTab('cutting');
        }

        function openConvertModal(cuttingId) {
            const cut = appData.cuttings.find(c => c.id === cuttingId);
            if(!cut) return;

            document.getElementById('convertCuttingId').value = cut.id;
            document.getElementById('convertModelInfo').textContent = `Model: ${cut.modelNumber} (${cut.totalPieces} Pcs Cut)`;
            document.getElementById('convertFabricInfo').textContent = `Product: ${cut.productName} | Fabric: ${cut.fabricYards} Yards`;
            document.getElementById('convertGoodPcs').value = cut.totalPieces;
            document.getElementById('convertWastagePcs').value = 0;
            
            openModal('convertCuttingModal');
        }

        function calcWastage() {
            const cutId = document.getElementById('convertCuttingId').value;
            const cut = appData.cuttings.find(c => c.id === cutId);
            if(!cut) return;

            const good = parseInt(document.getElementById('convertGoodPcs').value) || 0;
            const wastage = cut.totalPieces - good;
            document.getElementById('convertWastagePcs').value = wastage >= 0 ? wastage : 0;
        }

        function handleConvertSubmit(e) {
            e.preventDefault();
            const cutId = document.getElementById('convertCuttingId').value;
            const cut = appData.cuttings.find(c => c.id === cutId);
            if(!cut) return;

            const goodQty = parseInt(document.getElementById('convertGoodPcs').value);
            const prodCost = parseFloat(document.getElementById('convertProdCost').value);
            const sellingPrice = parseFloat(document.getElementById('convertSellingPrice').value);

            const newProd = {
                id: 'PRD-' + Date.now().toString().slice(-4),
                cuttingId: cut.id,
                modelNumber: cut.modelNumber,
                code: 'PRD-' + cut.modelNumber,
                name: cut.productName,
                stock: goodQty,
                cost: prodCost,
                price: sellingPrice,
                size: document.getElementById('convertSize').value,
                color: document.getElementById('convertColor').value
            };

            appData.products.push(newProd);
            cut.isConverted = true;
            cut.convertedQty = goodQty;

            appData.ledger.push({
                id: 'LEDG-' + Date.now().toString().slice(-4),
                date: new Date().toISOString().split('T')[0],
                type: 'Production',
                title: `তৈরি প্রোডাক্ট স্টক যোগ - ${cut.modelNumber}`,
                amount: goodQty,
                refId: newProd.id,
                note: `${goodQty} পিস ভালো স্টক এড করা হলো`
            });

            saveData();
            closeModal('convertCuttingModal');
            switchTab('products');
        }

        function handleDirectProductSubmit(e) {
            e.preventDefault();
            const newProd = {
                id: 'PRD-' + Date.now().toString().slice(-4),
                modelNumber: document.getElementById('prodModel').value.toUpperCase(),
                code: document.getElementById('prodCode').value || 'PRD-NEW',
                name: document.getElementById('prodName').value,
                stock: parseInt(document.getElementById('prodQty').value),
                cost: parseFloat(document.getElementById('prodCost').value) || 0,
                price: parseFloat(document.getElementById('prodPrice').value)
            };

            appData.products.push(newProd);

            appData.ledger.push({
                id: 'LEDG-' + Date.now().toString().slice(-4),
                date: new Date().toISOString().split('T')[0],
                type: 'Production',
                title: `ডিরেক্ট প্রোডাক্ট এড - ${newProd.modelNumber}`,
                amount: newProd.stock,
                refId: newProd.id,
                note: `রেডিমেড স্টক পরিমাণ: ${newProd.stock} পিস`
            });

            saveData();
            closeModal('addProductModal');
            document.getElementById('directProductForm').reset();
            switchTab('products');
        }

        function populateSaleDropdown() {
            const select = document.getElementById('saleSelectProduct');
            if (appData.products.length === 0) {
                select.innerHTML = '<option value="">কোন স্টক প্রোডাক্ট পাওয়া যায়নি!</option>';
                return;
            }
            select.innerHTML = appData.products.map(p => `
                <option value="${p.id}">${p.modelNumber} - ${p.name} (স্টক: ${p.stock} পিস)</option>
            `).join('');
            updateSalePrice();
        }

        function updateSalePrice() {
            const prodId = document.getElementById('saleSelectProduct').value;
            const prod = appData.products.find(p => p.id === prodId);
            if(prod) {
                document.getElementById('saleUnitPrice').value = prod.price;
                calcTotalSale();
            }
        }

        function calcTotalSale() {
            const qty = parseInt(document.getElementById('saleQty').value) || 0;
            const price = parseFloat(document.getElementById('saleUnitPrice').value) || 0;
            const total = qty * price;
            document.getElementById('saleTotalText').textContent = '৳ ' + total.toLocaleString();

            const saleType = document.getElementById('saleType').value;
            if (saleType === 'Cash') {
                document.getElementById('salePaidAmount').value = total;
            }
        }

        function toggleSaleTypeFields() {
            const saleType = document.getElementById('saleType').value;
            const paidWrapper = document.getElementById('paidAmountWrapper');
            const qty = parseInt(document.getElementById('saleQty').value) || 0;
            const price = parseFloat(document.getElementById('saleUnitPrice').value) || 0;
            const total = qty * price;

            if (saleType === 'Cash') {
                paidWrapper.style.display = 'block';
                document.getElementById('salePaidAmount').value = total;
            } else {
                paidWrapper.style.display = 'block';
                document.getElementById('salePaidAmount').value = 0;
            }
        }

        function handleSaleSubmit(e) {
            e.preventDefault();
            const prodId = document.getElementById('saleSelectProduct').value;
            const prod = appData.products.find(p => p.id === prodId);
            if(!prod) return;

            const qty = parseInt(document.getElementById('saleQty').value);
            const unitPrice = parseFloat(document.getElementById('saleUnitPrice').value);
            const totalSaleAmt = qty * unitPrice;
            const customerName = document.getElementById('saleCustomer').value.trim();
            const saleType = document.getElementById('saleType').value;
            const paidAmt = parseFloat(document.getElementById('salePaidAmount').value) || 0;

            if(qty > prod.stock) {
                alert('দুঃখিত! আপনার স্টকে পর্যাপ্ত প্রোডাক্ট নেই।');
                return;
            }

            prod.stock -= qty;
            const dueAmt = totalSaleAmt - paidAmt;

            if (!appData.salesRecords) appData.salesRecords = [];
            appData.salesRecords.push({
                date: new Date().toISOString().split('T')[0],
                productName: prod.name,
                modelNumber: prod.modelNumber,
                qty: qty,
                unitPrice: unitPrice,
                costPrice: prod.cost || 0,
                totalPrice: totalSaleAmt
            });

            const purchasedItem = {
                date: new Date().toISOString().split('T')[0],
                productName: prod.name,
                modelNumber: prod.modelNumber,
                qty: qty,
                unitPrice: unitPrice,
                totalPrice: totalSaleAmt
            };

            if (saleType === 'Due' || dueAmt > 0) {
                let existingDue = appData.dueBook.find(d => d.customerName.toLowerCase() === customerName.toLowerCase());
                if (existingDue) {
                    existingDue.dueAmount += dueAmt;
                    existingDue.totalPurchased = (existingDue.totalPurchased || 0) + totalSaleAmt;
                    existingDue.totalPaid = (existingDue.totalPaid || 0) + paidAmt;
                    existingDue.lastDate = new Date().toISOString().split('T')[0];
                    if (!existingDue.items) existingDue.items = [];
                    existingDue.items.push(purchasedItem);
                } else {
                    appData.dueBook.push({
                        id: 'DUE-' + Date.now().toString().slice(-4),
                        customerName: customerName,
                        dueAmount: dueAmt,
                        totalPurchased: totalSaleAmt,
                        totalPaid: paidAmt,
                        lastDate: new Date().toISOString().split('T')[0],
                        items: [purchasedItem]
                    });
                }
            }

            appData.ledger.push({
                id: 'LEDG-' + Date.now().toString().slice(-4),
                date: new Date().toISOString().split('T')[0],
                type: 'Sale',
                title: `প্রোডাক্ট বিক্রি (${saleType === 'Cash' ? 'নগদ' : 'বাকি'}) - ${prod.modelNumber}`,
                amount: paidAmt,
                refId: prod.id,
                note: `কাস্টমার: ${customerName}, ${qty} পিস। মোট: ৳${totalSaleAmt}, জমা: ৳${paidAmt}, বাকি: ৳${dueAmt}`
            });

            saveData();
            closeModal('addSaleModal');
            switchTab('dashboard');
            alert(`বিক্রি সফলভাবে সম্পন্ন হয়েছে! ${dueAmt > 0 ? 'বাকি খাতা ও প্রোডাক্ট ডিটেইলস আপডেট করা হয়েছে।' : ''}`);
        }

        function deleteExpense(id) {
            appData.expenses = appData.expenses.filter(e => e.id !== id);
            appData.ledger = appData.ledger.filter(l => l.refId !== id);
            saveData();
            renderExpenses(document.getElementById('appContent'));
        }

        function deleteCutting(id) {
            appData.cuttings = appData.cuttings.filter(c => c.id !== id);
            appData.ledger = appData.ledger.filter(l => l.refId !== id);
            saveData();
            renderCutting(document.getElementById('appContent'));
        }

        function deleteProduct(id) {
            appData.products = appData.products.filter(p => p.id !== id);
            appData.ledger = appData.ledger.filter(l => l.refId !== id);
            saveData();
            renderProducts(document.getElementById('appContent'));
        }

        window.onload = function() {
            initData();
        };
    </script>
</body>
</html>