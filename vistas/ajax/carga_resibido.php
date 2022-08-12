		<label for="resibido">Dinero Resibido</label>
		<input style=" background-color:#F5B7B1; border-radius: 5px; border: 1px solid #39c; text-align: center; font-size: 30px; height: 50px" type="text" class="form-control resibido" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" autocomplete="off" id="resibido" required name="resibido" tabindex="3" placeholder="$ 0.00">
		<script type="text/javascript">
			$(function() {

				$('.resibido').keyup(function(e) {
						if (this.value != '-')
							while (isNaN(this.value))
								this.value = this.value.split('').reverse().join('').replace(/[\D]/i, '')
								.split('').reverse().join('');
					})
					.on("cut copy paste", function(e) {
						e.preventDefault();
					});

			});
		</script>