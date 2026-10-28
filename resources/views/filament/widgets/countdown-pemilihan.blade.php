<x-filament::widget>
    <x-filament::card>

        @php $data = $this->getData(); @endphp

        @if (! $data['mulai'] || ! $data['selesai'])
            <div style="display:flex; align-items:center; justify-content:center; padding:1rem; font-size:13px; color:#9ca3af;">
                Belum ada data pemilihan.
            </div>
        @else
            <div
                x-data="{
                    d: '00', h: '00', m: '00', s: '00',
                    pct: 0, selesai: false,
                    init() {
                        const end   = new Date('{{ $data['selesai'] }}').getTime();
                        const start = new Date('{{ $data['mulai'] }}').getTime();
                        const total = end - start;
                        const pad   = n => String(n).padStart(2, '0');
                        const tick  = () => {
                            const now  = Date.now();
                            const dist = end - now;
                            if (dist <= 0) { this.selesai = true; this.pct = 100; return; }
                            this.d   = pad(Math.floor(dist / 86400000));
                            this.h   = pad(Math.floor((dist % 86400000) / 3600000));
                            this.m   = pad(Math.floor((dist % 3600000)  / 60000));
                            this.s   = pad(Math.floor((dist % 60000)    / 1000));
                            this.pct = Math.min(100, Math.round(((now - start) / total) * 100));
                        };
                        tick(); setInterval(tick, 1000);
                    }
                }"
                x-init="init()"
                style="display:flex; flex-direction:column; align-items:center; gap:16px; padding:16px 0;"
            >

                <p style="font-size:11px; letter-spacing:0.1em; text-transform:uppercase; color:#9ca3af; margin:0;">
                    Countdown Pemilihan
                </p>

                {{-- Jam digital — pakai x-bind:style bukan x-show --}}
                <div
                    x-bind:style="selesai ? 'display:none' : 'display:flex'"
                    style="display:flex; flex-direction:row; align-items:flex-end; gap:8px;"
                >
                    {{-- Hari --}}
                    <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                        <div style="display:flex; flex-direction:row; gap:3px;">
                            <div x-text="d[0]" class="cd-box"></div>
                            <div x-text="d[1]" class="cd-box"></div>
                        </div>
                        <span style="font-size:11px; color:#9ca3af;">Hari</span>
                    </div>

                    <span class="cd-sep">:</span>

                    {{-- Jam --}}
                    <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                        <div style="display:flex; flex-direction:row; gap:3px;">
                            <div x-text="h[0]" class="cd-box"></div>
                            <div x-text="h[1]" class="cd-box"></div>
                        </div>
                        <span style="font-size:11px; color:#9ca3af;">Jam</span>
                    </div>

                    <span class="cd-sep">:</span>

                    {{-- Menit --}}
                    <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                        <div style="display:flex; flex-direction:row; gap:3px;">
                            <div x-text="m[0]" class="cd-box"></div>
                            <div x-text="m[1]" class="cd-box"></div>
                        </div>
                        <span style="font-size:11px; color:#9ca3af;">Menit</span>
                    </div>

                    <span class="cd-sep">:</span>

                    {{-- Detik --}}
                    <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                        <div style="display:flex; flex-direction:row; gap:3px;">
                            <div x-text="s[0]" class="cd-box"></div>
                            <div x-text="s[1]" class="cd-box"></div>
                        </div>
                        <span style="font-size:11px; color:#9ca3af;">Detik</span>
                    </div>
                </div>

                {{-- Selesai --}}
                <div
                    x-bind:style="selesai ? 'display:block' : 'display:none'"
                    style="display:none; background:#fef2f2; color:#dc2626; padding:10px 24px; border-radius:8px; font-size:13px; font-weight:500;"
                >
                    Pemilihan telah selesai
                </div>

                {{-- Progress bar --}}
                <div style="width:100%; max-width:400px;">
                    <div style="height:4px; background:#f3f4f6; border-radius:99px; overflow:hidden;">
                        <div
                            :style="`width:${pct}%; height:100%; background:#6366f1; border-radius:99px; transition:width 1s linear;`"
                        ></div>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-top:6px; font-size:11px; color:#9ca3af;">
                        <span>Mulai</span>
                        <span>Selesai</span>
                    </div>
                </div>

            </div>

            <style>
                .cd-box {
                    width: 44px;
                    height: 58px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #f9fafb;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    font-size: 28px;
                    font-weight: 600;
                    font-family: ui-monospace, monospace;
                    color: #111827;
                }
                .dark .cd-box {
                    background: #111827;
                    border-color: #374151;
                    color: #f9fafb;
                }
                .cd-sep {
                    font-size: 26px;
                    font-weight: 400;
                    color: #d1d5db;
                    line-height: 1;
                    margin-bottom: 22px;
                }
            </style>
        @endif

    </x-filament::card>
</x-filament::widget>