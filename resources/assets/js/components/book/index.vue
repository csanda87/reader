<template>
    <div class="card card-default">
        <div class="card-header">Books</div>

        <div class="card-body">
            <div v-if="loading">Loading...</div>
            <div v-else class="list-group list-group-flush">
                <a v-for="book in filteredBooks" :href="'/books/'+book.id" class="list-group-item list-group-item-action"><b>{{ book.title }}</b> - {{ book.author }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: [],
                loading: false,
                searchQuery: ''
            }
        },
        computed: {
            filteredBooks() {
                return this.books.filter((book) => {
                    if (this.searchQuery == '') {
                        return true;
                    }

                    let searchTitle = book.title.toLowerCase();
                    let searchAuthor = book.author.toLowerCase();
                    return searchTitle.indexOf(this.searchQuery.toLowerCase()) > -1 || searchAuthor.indexOf(this.searchQuery.toLowerCase()) > -1;
                })
            }
        },
        methods: {
            getBooks() {
                axios.get('/api/books')
                    .then((response) => {
                        this.books = response.data;
                        this.loading = false;
                    });
            }
        },
        created() {
            this.loading = true;
            this.getBooks();
        }
    }
</script>
