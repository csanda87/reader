<template>
    <div class="card card-default">
        <div class="card-header">
            <h1 class="m-0 float-left">Books</h1>
            <a href="/books/create" class="btn btn-primary float-right ml-1">
                <svg class="i-plus" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M16 2 L16 30 M2 16 L30 16"></path>
                </svg>
            </a>
            <button @click="toggleSearch" class="btn btn-default float-right ml-1">
                <svg class="i-search" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <circle cx="14" cy="14" r="12"></circle>
                    <path d="M23 23 L30 30"></path>
                </svg>
            </button>
        </div>

        <div v-if="loading" class="card-body">Loading...</div>
        <div v-else>
            <div v-if="showSearch">
                <input v-model="searchQuery" type="text" class="form-control" placeholder="Search...">
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>
                            <a href="#" @click="sortBy('title')">
                                Title
                            </a>
                        </th>
                        <th>
                            <a href="#" @click="sortBy('author')">
                                Author
                            </a>
                        </th>
                        <th>Pub. Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in filteredBooks">
                        <td width="50px">
                            <a :href="'/books/'+book.id">
                                <img v-if="book.image" :src="'/storage/'+book.image" :alt="book.title" class="img-fluid">
                            </a>
                            
                        </td>
                        <td>
                            <a :href="'/books/'+book.id">
                                {{ book.title }}
                            </a>
                        </td>
                        <td>{{ book.author }}</td>
                        <td width="100px">{{ book.publication_date }}</td>
                        <td width="25px" class="text-danger">
                            <button @click="deleteBook(book.id)" class="btn btn-sm btn-outline-danger">
                                <svg class="i-trash" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- <div v-else class="list-group list-group-flush">
            <a v-for="book in filteredBooks" :href="'/books/'+book.id" class="list-group-item list-group-item-action"><b>{{ book.title }}</b> - {{ book.author }}</a>
        </div> -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: [],
                loading: false,
                searchQuery: '',
                showSearch: false,
                sortKey: '',
                sortReverse: false,
            }
        },
        computed: {
            filteredBooks() {
                return this.books.filter((book) => {
                    if (this.searchQuery == '' && this.sortKey == '') {
                        return true;
                    }

                    // if (this.sortKey == 'author') {
                    //     return this.books.sort((a,b) => {
                    //         if (a.author < b.author) return -1;
                    //         if (a.author > b.author) return 1;
                    //         return 0;
                    //     });
                    // }

                    let searchTitle = book.title.toLowerCase();
                    let searchAuthor = book.author.toLowerCase();
                    return searchTitle.indexOf(this.searchQuery.toLowerCase()) > -1 || searchAuthor.indexOf(this.searchQuery.toLowerCase()) > -1;


                })
            }
        },
        methods: {
            deleteBook(id) {
                if (window.confirm("Are you sure you want to remove this book?")) { 
                    alert('delete book id ' + id);
                    axios.delete('/api/books/' + id)
                        .then((response) => {
                            this.books = this.books.filter((book) => {
                                return book.id !== id;
                            });
                        }).catch((error) => {
                            alert('There was an error deleting the book.');
                        });
                }
            },
            getBooks() {
                axios.get('/api/books')
                    .then((response) => {
                        this.books = response.data;
                        this.loading = false;
                    });
            },
            sortBy(sortKey) {
                this.sortReverse = (this.sortKey == sortKey) ? !this.sortReverse : false;
                this.sortKey = sortKey;
            },
            toggleSearch() {
                this.showSearch = !this.showSearch;
            }
        },
        created() {
            this.loading = true;
            this.getBooks();
        }
    }
</script>
