-- =====================================================
-- Object:  Table [dbo].[clientes]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[clientes] (
    [id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[empresa] [nvarchar](255) NOT NULL,
	[fecha_creacion] [date] NOT NULL,
	[telefono] [nvarchar](50) NULL,
	[direccion] [nvarchar](max) NULL,
	[estado_id] [int] NULL,
	[cedula] [varchar](50) NULL,

    CONSTRAINT FK_clientes_estados FOREIGN KEY (estado_id)
        REFERENCES [dbo].[estados_clientes] (id)
);