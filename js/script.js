function changeInput(placeholder) {
					if (this.value == placeholder) {
						this.value='';
						this.style.color='#000000';
					}
				}
				
				function changeInputBack(placeholder) {
					if (this.value == '') { 
						this.value= placeholder;
						this.style.color='#666666';
					}
				}