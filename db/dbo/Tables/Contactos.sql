-- =====================================================
-- Object:  Table [dbo].[Contactos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Contactos] (
    [ID_Contactos] [int] NOT NULL,
	[Nombre] [varchar](50) NOT NULL,
	[Telefono] [int] NOT NULL,
	[Correo] [varchar](100) NOT NULL,
	[idioma_Traduccion] [varchar](100) NOT NULL
);