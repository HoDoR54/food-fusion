@php
    use App\Enums\ContactFormSubmissionType;
@endphp

<div class="border-2 border-dashed border-primary/30 bg-white/60 rounded-2xl">
    <div class="border-b border-dashed border-primary/20 p-6">
        <h2 class="text-xl font-bold text-primary">Contact Us</h2>
    </div>

    <form id="contact-form" method="POST" class="p-6 flex flex-col gap-6">
        @csrf

        <div class="flex flex-col gap-4">
            <!-- Subject -->
            <div class="flex flex-col gap-2">
                <label for="subject" class="block text-sm text-text/60">Subject</label>
                <input type="text" id="subject" name="subject" required placeholder="e.g. Feedback about the website"
                    class="border border-dashed border-primary/30 bg-secondary/15 px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full" />
            </div>

            <!-- Type -->
            <div class="flex flex-col gap-2">
                <label for="type" class="block text-sm text-text/60">Submission Type</label>
                <div class="relative">
                    <select
                        id="type"
                        name="type"
                        required
                        class="border border-dashed border-primary/30 bg-secondary/15 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text"
                    >
                        <option value="" disabled selected>Select type</option>
                        @foreach (ContactFormSubmissionType::cases() as $case)
                            <option value="{{ $case->value }}">{{ $case->label() }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Message -->
            <div class="flex flex-col gap-2">
                <label for="message" class="block text-sm text-text/60">Message</label>
                <textarea id="message" name="message" required
                    placeholder="Write your message here..."
                    class="border border-dashed border-primary/30 bg-secondary/15 resize-none px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full min-h-[120px]"
                    rows="5"></textarea>
            </div>

            <!-- Anonymous Toggle -->
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1"
                    class="w-4 h-4 border border-dashed border-primary/30 rounded focus:ring-2 focus:ring-primary" />
                <label for="is_anonymous" class="text-sm text-text/60">Submit anonymously</label>
            </div>
        </div>

        <div class="pt-6 border-t border-dashed border-primary/30">
            <button type="submit"
                class="w-full bg-primary hover:bg-primary/90 text-white py-3 px-8 rounded-lg transition font-semibold flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="send" class="w-5 h-5"></i>
                Submit Contact Form
            </button>
            <p class="text-sm text-text/60 text-center mt-3">
                Your message will be sent to our support team. We’ll get back to you as soon as possible.
            </p>
        </div>
    </form>
</div>
