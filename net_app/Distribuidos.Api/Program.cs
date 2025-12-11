using Distribuidos.Api.Services.Pipedream;

var builder = WebApplication.CreateBuilder(args);

// Habilitar controladores
builder.Services.AddControllers();

// Inyectar el servicio como Singleton
builder.Services.AddSingleton<IPipedreamService, PipedreamService>();

var app = builder.Build();

app.UseHttpsRedirection();

app.UseAuthorization();

// Mapea tus controladores (rutas tipo /api/...)
app.MapControllers();

app.Run();
