<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import 'emoji-picker-element'; // Import the emoji picker

import { ref } from 'vue';

dayjs.extend(relativeTime);

// Props
defineProps(['chirp']);

// Reply state
const replyMessage = ref(''); // Stores the reply text

// Emoji picker visibility
const showEmojiPicker = ref(false); // Controls the visibility of the emoji picker

// Emoji click handler
const addEmoji = (event) => {
    replyMessage.value += event.detail.unicode; // Append the emoji to the reply message
};

// Submit reply (for now, it just logs the message; you can integrate it with your backend or other logic)
const submitReply = () => {
    console.log('Reply submitted:', replyMessage.value);
    replyMessage.value = ''; // Clear the input after submission
};

// Toggle emoji picker visibility
const toggleEmojiPicker = () => {
    showEmojiPicker.value = !showEmojiPicker.value;
};
</script>

<template>
    <div class="p-6 flex space-x-2 bg-blue-100 rounded-lg shadow-sm">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-gray-600 -scale-x-100"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
            />
        </svg>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800 font-semibold">{{ chirp.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(chirp.created_at).fromNow() }}</small>
                </div>
            </div>
            <p class="mt-4 text-lg text-gray-900">{{ chirp.message }}</p>

            <!-- Navy Blue Buttons -->
            <div class="mt-4">
                <button
                    class="px-4 py-2 bg-blue-900 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring focus:ring-blue-300"
                >
                    Like
                </button>
                <button
                    class="px-4 py-2 bg-blue-900 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring focus:ring-blue-300 ml-2"
                >
                    Reply
                </button>
            </div>

            <!-- Reply Section -->
            <div class="mt-6 p-4 bg-white shadow rounded-md">
                <textarea
                    v-model="replyMessage"
                    placeholder="Type your reply..."
                    class="w-full p-2 border rounded"
                ></textarea>

                <!-- Emoji Button (to toggle the emoji picker visibility) -->
                <button
                    @click="toggleEmojiPicker"
                    class="mt-2 px-4 py-2 bg-gray-200 text-gray-600 rounded-md hover:bg-gray-300 focus:outline-none"
                >
                    😀
                </button>

                <!-- Emoji Picker (conditionally rendered based on visibility state) -->
                <div v-if="showEmojiPicker">
                    <emoji-picker @emoji-click="addEmoji" class="mt-2"></emoji-picker>
                </div>

                <!-- Submit Button -->
                <button
                    @click="submitReply"
                    class="mt-2 px-4 py-2 bg-blue-900 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring focus:ring-blue-300"
                >
                    Submit Reply
                </button>
            </div>
        </div>
    </div>
</template>
