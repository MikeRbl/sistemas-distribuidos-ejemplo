using Distribuidos.Api.Models.Pipedream;

namespace Distribuidos.Api.Services.Pipedream
{
    public interface IPipedreamService
    {
        Task<bool> SendWelcome(WelcomeModel body);
    }
}