<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Books</div>

                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Cras justo odio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: [],
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
                    });
            }
        },
        created() {
            this.getBooks();
        }
    }
</script>
