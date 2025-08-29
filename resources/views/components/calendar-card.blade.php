<div x-data="calendarComponent()" x-init="init()" class="card-gradient rounded-xl shadow-lg border border-gray-100 p-6 hover-subtle select-none">
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-lg font-bold text-gray-900" x-text="monthYear"></h4>
        <div class="flex items-center gap-2">
            <button @click="prevMonth()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-700">
                &lt;
            </button>
            <button @click="nextMonth()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-700">
                &gt;
            </button>
        </div>
    </div>

    <div class="grid grid-cols-7 text-center text-xs font-semibold text-gray-500 mb-2">
        <div>Sun</div>
        <div>Mon</div>
        <div>Tue</div>
        <div>Wed</div>
        <div>Thu</div>
        <div>Fri</div>
        <div>Sat</div>
    </div>

    <div class="grid grid-cols-7 gap-2">
        <template x-for="(day, idx) in days" :key="idx">
            <div class="aspect-square">
                <div
                    class="w-full h-full flex items-center justify-center rounded-lg text-sm"
                    :class="{
                        'bg-gray-50 text-gray-400': !day.current,
                        'bg-white text-gray-700': day.current,
                        'gradient-bg text-white shadow': day.isToday
                    }"
                >
                    <span x-text="day.date"></span>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    function calendarComponent() {
        return {
            today: new Date(),
            current: new Date(),
            days: [],
            get monthYear() {
                return this.current.toLocaleDateString(undefined, { month: 'long', year: 'numeric' });
            },
            init() {
                this.build();
            },
            build() {
                const firstDay = new Date(this.current.getFullYear(), this.current.getMonth(), 1);
                const lastDay = new Date(this.current.getFullYear(), this.current.getMonth() + 1, 0);
                const prevDays = firstDay.getDay();
                const totalDays = lastDay.getDate();
                const days = [];

                // Previous month days
                for (let i = prevDays; i > 0; i--) {
                    const d = new Date(this.current.getFullYear(), this.current.getMonth(), 1 - i);
                    days.push({ date: d.getDate(), current: false, isToday: this.isSameDate(d, this.today) });
                }

                // Current month days
                for (let d = 1; d <= totalDays; d++) {
                    const dateObj = new Date(this.current.getFullYear(), this.current.getMonth(), d);
                    days.push({ date: d, current: true, isToday: this.isSameDate(dateObj, this.today) });
                }

                // Next month days to complete grid (up to 42 cells)
                const remaining = 42 - days.length;
                for (let i = 1; i <= remaining; i++) {
                    const d = new Date(this.current.getFullYear(), this.current.getMonth() + 1, i);
                    days.push({ date: d.getDate(), current: false, isToday: this.isSameDate(d, this.today) });
                }

                this.days = days;
            },
            prevMonth() {
                // Reassign a new Date to ensure Alpine reactivity picks up the change
                this.current = new Date(
                    this.current.getFullYear(),
                    this.current.getMonth() - 1,
                    1
                );
                this.build();
            },
            nextMonth() {
                // Reassign a new Date to ensure Alpine reactivity picks up the change
                this.current = new Date(
                    this.current.getFullYear(),
                    this.current.getMonth() + 1,
                    1
                );
                this.build();
            },
            isSameDate(a, b) {
                return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
            }
        }
    }
</script>


