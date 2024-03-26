    <div style="height: 90px;"></div>
    <script>
		const list =  document.querySelectorAll(".list");
		function activeLink(){
			list.forEach((item) =>
			item.classList.remove("active"));
			this.classList.add("active");
		}
		list.forEach((item) =>
		item.addEventListener('click', activeLink));

	</script>

<script src="js/custom.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

 

 


</body>
</html>