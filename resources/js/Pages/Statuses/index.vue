<template>
    <div>
        <h1>This is the Test Page</h1>
        <p>Welcome to the test page!</p>
    </div>

    <h3>List of statuses:</h3>
    <ul>
        <li v-for="status in statuses" :key="status.id">
            {{ status.name }}
        </li>
    </ul>

    <h2>Add new status</h2>
    <form @submit.prevent="submit">
        <label for="title">Title</label>
        <input id="title" name="title" type="text" v-model="form.title">

        <button type="submit">Add</button>

    </form>

    <div v-if="$page.props.flash.message">
        {{ $page.props.flash.message }}
    </div>
</template>
<script>
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        statuses: Array
    },
    setup() {
        const form = useForm({
            title: ''
        });

        function submit() {

            form.post(route('statuses.store'));

        }

        return { form, submit };
    }
}
</script>
