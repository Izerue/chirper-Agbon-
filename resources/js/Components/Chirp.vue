<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';



dayjs.extend(relativeTime);

// Props
const props = defineProps(['chirp']); // Added authUser to check ownership

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

const form = useForm({
    message: props.chirp.message,
});

const editing = ref(false);

// Delete chirp method
const deleteChirp = () => {
    if (confirm('Are you sure you want to delete this chirp?')) {
        router.delete(route('chirps.destroy', chirp.id), {
            onSuccess: () => console.log('Chirp deleted successfully.'),
        });
    }
};
</script>

<template>
    <div class="relative p-6 flex space-x-2 bg-blue-100 rounded-lg shadow-sm">
        <!-- Chirp Content -->
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
                    <small v-if="chirp.created_at !== chirp.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>

                <!-- Dropdown -->
                <Dropdown v-if="chirp.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                                />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <!-- Edit Option -->
                        <button
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                            @click="editing = true"
                        >
                            Edit
                        </button>
                        <!-- Delete Option -->
                        <DropdownLink
                            as="button"
                            :href="route('chirps.destroy', chirp.id)"
                            method="delete"
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-red-600 hover:bg-red-100 focus:bg-red-100 transition duration-150 ease-in-out"
                        >
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>

            <!-- Form for Editing Chirps -->
            <form
                v-if="editing"
                @submit.prevent="form.put(route('chirps.update', chirp.id), { onSuccess: () => (editing = false) })"
            >
                <textarea
                    v-model="form.message"
                    class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button
                        type="button"
                        class="mt-4 text-gray-600 hover:text-gray-800"
                        @click="editing = false; form.reset(); form.clearErrors()"
                    >
                        Cancel
                    </button>
                </div>
            </form>

            <!-- Display Message When Not Editing -->
            <p v-else class="mt-4 text-lg text-gray-900">{{ chirp.message }}</p>

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
        </div>
    </div>
</template>

