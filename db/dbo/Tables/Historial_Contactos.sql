-- =====================================================
-- Object:  Table [dbo].[Historial_Contactos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Historial_Contactos] (
    [ID] [int] IDENTITY(1,1) NOT NULL,
	[ContactoID] [int] NULL,
	[Accion] [nvarchar](255) NULL,
	[NombreAnterior] [nvarchar](255) NULL,
	[FechaAccion] [datetime] NULL,
	[Usuario] [nvarchar](100) NULL,
	[Mensaje] [nvarchar](max) NULL,
	[notificaciones_check] [bit] NULL DEFAULT 0,

    CONSTRAINT FK_Historial_ContactoID FOREIGN KEY (ContactoID)
        REFERENCES [dbo].[lista_contactos] (id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);