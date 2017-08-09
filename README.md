## This is a [research code](https://meiert.com/en/blog/20140716/research-and-production/).

# Multiple writes to the same `xml` file with `compress.zlib://` stream would fail to decode in browsers

Sample files could be generated in `generate-files.php` and served via `serve.php`. 

How to check this issue?

```sh
composer start-server

# in the other terminal
composer check
```

Try how different files served:

* http://localhost:8000/serve.php?file=multi
* http://localhost:8000/serve.php?file=remulti
* http://localhost:8000/serve.php?file=one