using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Distribuidos.Api.Services.Pipedream;
using Distribuidos.Api.Models.Pipedream;
namespace MyApp.Namespace
{
    [Route("api/[controller]")]
    [ApiController]
    public class PipedreamController : ControllerBase
    {
        //Instancia
        private readonly IPipedreamService _pipedreamService;
        //Constructor
        public PipedreamController(IPipedreamService pipedreamService)
        {
            //Inicializacion
            _pipedreamService = pipedreamService;
        }
        //Metodo para enviar el correo de bienvenida
        [HttpPost("welcome")]
        public async Task<IActionResult> WelcomeEmail([FromBody] WelcomeModel body)
        {
            try
            {
                bool res = await _pipedreamService.SendWelcome(body);

                return Ok(new
                {
                    error = false,
                    msj = res
                });
            } catch (Exception ex)
            {
                return BadRequest(new
                {
                    error = true,
                    msj = ex.Message
                });
            }
            
        }
    }
}
