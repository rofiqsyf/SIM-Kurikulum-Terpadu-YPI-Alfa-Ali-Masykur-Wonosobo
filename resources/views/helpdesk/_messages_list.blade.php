@forelse($messages as $msg)
    @php
        $isMe = $msg->sender_id === $currentUser->id;
        $sender = $msg->sender;
        $isSenderAdmin = $msg->isSenderAdmin();
    @endphp

    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} items-end gap-2.5">
        @if(!$isMe)
            <div class="w-8 h-8 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm" title="{{ $sender->name ?? 'Pengirim' }}">
                {{ substr($sender->name ?? 'P', 0, 1) }}
            </div>
        @endif

        <div class="max-w-md sm:max-w-lg space-y-1 {{ $isMe ? 'text-right' : 'text-left' }}">
            @if(!$isMe)
                <div class="flex items-center gap-1.5 pl-1">
                    <span class="text-[10px] font-semibold text-slate-600">{{ $sender->name ?? 'User' }}</span>
                    @if($isSenderAdmin)
                        <span class="px-1.5 py-0.2 rounded-md bg-brand-100 text-brand-800 text-[9px] font-bold">Admin IT</span>
                    @else
                        <span class="text-[9px] text-slate-400">({{ $sender->peran->nama_peran ?? 'Pengguna' }})</span>
                    @endif
                </div>
            @endif

            <div class="inline-block p-4 rounded-3xl {{ $isMe ? 'rounded-br-none bg-gradient-to-r from-brand-800 to-brand-900 text-white' : 'rounded-bl-none bg-white text-slate-800 border border-slate-100' }} shadow-card text-left">
                @if($msg->pesan)
                    <p class="text-xs leading-relaxed whitespace-pre-wrap">{{ $msg->pesan }}</p>
                @endif

                <!-- Attachment rendering -->
                @if($msg->hasAttachment())
                    @if($msg->isImage())
                        <!-- Image Attachment with Lightbox -->
                        <div class="mt-2 rounded-2xl overflow-hidden border {{ $isMe ? 'border-white/20' : 'border-slate-200' }} max-w-xs cursor-pointer group relative"
                             onclick="openImageLightbox('{{ $msg->file_url }}', '{{ $msg->file_name }}')">
                            <img src="{{ $msg->file_url }}" alt="{{ $msg->file_name }}" class="w-full h-auto object-cover max-h-56 group-hover:scale-105 transition-transform duration-200">
                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white gap-1 text-xs font-semibold">
                                <span class="material-symbols-outlined text-base">zoom_in</span>
                                <span>Perbesar</span>
                            </div>
                        </div>
                        <div class="text-[10px] mt-1 {{ $isMe ? 'text-white/70' : 'text-slate-400' }} truncate max-w-[220px]">
                            {{ $msg->file_name }} ({{ $msg->file_size }})
                        </div>
                    @else
                        <!-- Document Attachment Card -->
                        @php $badge = $msg->file_badge; @endphp
                        <div class="mt-2.5 p-2.5 rounded-2xl {{ $isMe ? 'bg-white/10 border border-white/20' : 'bg-slate-50 border border-slate-200' }} flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-xl {{ $isMe ? 'bg-white/20 text-white' : $badge['badge_class'] }} flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-lg">{{ $badge['icon'] }}</span>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-semibold truncate {{ $isMe ? 'text-white' : 'text-slate-800' }}" title="{{ $msg->file_name }}">
                                        {{ $msg->file_name }}
                                    </div>
                                    <div class="text-[10px] {{ $isMe ? 'text-white/70' : 'text-slate-400' }}">
                                        {{ $msg->file_size }} • {{ $badge['label'] }}
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('helpdesk.download', $msg->id) }}" 
                               class="p-2 rounded-xl {{ $isMe ? 'bg-white/20 hover:bg-white/30 text-white' : 'bg-brand-50 hover:bg-brand-100 text-brand-800' }} transition-all shrink-0 cursor-pointer" 
                               title="Unduh Berkas">
                                <span class="material-symbols-outlined text-base">download</span>
                            </a>
                        </div>
                    @endif
                @endif
            </div>

            <div class="flex items-center {{ $isMe ? 'justify-end' : 'justify-start' }} gap-1.5 text-[10px] text-slate-400 px-1">
                <span>{{ $msg->created_at->format('H:i') }}</span>
                @if($isMe)
                    <span class="material-symbols-outlined text-xs {{ $msg->is_read ? 'text-brand-700' : 'text-slate-300' }}">done_all</span>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="h-full flex flex-col items-center justify-center py-16 text-center text-slate-400 space-y-2">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
            <span class="material-symbols-outlined text-2xl">chat_bubble_outline</span>
        </div>
        <p class="text-xs font-semibold text-slate-600">Belum ada pesan dalam sesi ini.</p>
        <p class="text-[11px] text-slate-400 max-w-xs">Silakan ketik pertanyaan, kendala teknis, atau lampirkan berkas dokumen/gambar untuk memulai konsultasi dengan Administrator.</p>
    </div>
@endforelse

