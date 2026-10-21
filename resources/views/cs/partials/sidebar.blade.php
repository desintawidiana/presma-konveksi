```blade
<aside
    class="cs-sidebar fixed left-0 top-0 z-50 flex h-full w-64 select-none flex-col justify-between bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)]"
    id="cs-sidebar"
>
    <div class="flex flex-col">
        {{-- Logo dan nama aplikasi --}}
        <div class="flex h-16 items-center gap-space-sm bg-surface-container-lowest px-space-md">
            <div class="flex w-full items-center gap-3">
                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBI7NzLLvbSZK-R70072_RFmOBCKj09oADam5Dq4uAMA0OfCPsFCYuLj9GPsA4sxxj36JA5X5Y7BVwOJl4HPuJ8V0xhXCsTAiYhjsz0WxYotg5ILTSBJE5UNLt3G44NtGkbK1HatrjXAxThAwCchCNihTTWGxFBeIDzOA1rgRK6FvRO3wv5eOivrtsOx1NKtBTziuGE6KVM7PJ17Rn8RPt-20SCK9M7WbctTZaZZX1hL9FMvgJbM8JwWPFT2UZlvOmf6k4"
                    alt="Presma Logo"
                    class="h-9 w-9 shrink-0 rounded object-contain"
                >

                <div class="flex min-w-0 flex-col leading-tight">
                    <span class="truncate text-title-sm font-bold uppercase tracking-tight text-on-surface">
                        PRESMA KONVEKSI
                    </span>
                    <span class="text-label-sm font-semibold uppercase tracking-wider text-secondary">
                        CS WORKSPACE
                    </span>
                </div>
            </div>
        </div>

        {{-- Judul menu --}}
        <div class="px-space-md pb-space-xs pt-space-md">
            <span class="text-label-sm font-semibold uppercase tracking-wider text-secondary">
                Menu Operasional
            </span>
        </div>

        {{-- Navigasi --}}
        <nav
            class="flex flex-col gap-1 px-space-sm"
            data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm"
        >
            <a
                href="{{ route('dashboard.cs') }}"
                aria-current="page"
                class="flex items-center gap-3 rounded-lg bg-[#F7E7E7] px-3 py-2 font-semibold text-[#830909] transition-colors"
                data-path="cs-dashboard"
            >
                <span class="material-symbols-outlined text-[20px] text-[#830909]">grid_view</span>
                <span>Dashboard</span>
            </a>

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="customer-management"
            >
                <span class="material-symbols-outlined text-[20px]">people</span>
                <span>Customer</span>
            </a>

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="order-management"
            >
                <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                <span>Order</span>
            </a>

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="work-order"
            >
                <span class="material-symbols-outlined text-[20px]">assignment</span>
                <span>Work Order</span>
            </a>

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="invoice-and-pembayaran"
            >
                <span class="material-symbols-outlined text-[20px]">payments</span>
                <span>Invoice &amp; Pembayaran</span>
            </a>

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="order-tracking"
            >
                <span class="material-symbols-outlined text-[20px]">near_me</span>
                <span>Tracking</span>
            </a>
        </nav>
    </div>

    {{-- Status dan logout --}}
    <div class="flex flex-col gap-3 bg-surface-container-low p-space-md">
        <div class="flex items-center justify-between rounded-lg bg-surface-container-lowest px-3 py-2 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 animate-pulse rounded-full bg-primary-container"></span>
                <span class="text-label-sm font-medium text-secondary">
                    CS Workspace
                </span>
            </div>

            <span class="text-label-sm font-semibold text-primary-container">
                Aktif
            </span>
        </div>

        <div class="border-t border-[#D9DADB] pt-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-label-md text-error transition-colors hover:bg-[#F7E7E7] hover:text-[#830909]"
                >
                    <span class="font-medium">Keluar Akun</span>
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
```